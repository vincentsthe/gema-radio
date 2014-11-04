<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Session;

use app\models\db\Transaksi;
use app\models\db\Akun;
use app\models\db\TransaksiLain;
use app\modules\manajerkeuangan\models\BukuBesar;
use app\models\form\ConfirmationForm;
use app\models\factory\TransaksiLainFactory;

class TransaksiController extends BaseController {

	public function behaviors(){
		return ArrayHelper::merge([
			//allow access to direktur
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function($rule,$action){
							if (isset(Yii::$app->user->identity)){
								return Yii::$app->user->identity->isDirektur();
							}
							else
								return false;
						}		
					],
				]
			]
		],parent::behaviors());
	}

	public $defaultAction = 'index';

    public function actionIndex()
    {
    	$model = new TransaksiSearch;
    	$dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index',[
        	'model' => $model,
        	'akuns' => $akuns,
        	'dataProvider' => $dataProvider,
        ]);
    }


	public function actionAdd() {
		$model = new TransaksiLain();
		$akun = Akun::find()->all();

		if((Yii::$app->request->isPost) && ($model->load(Yii::$app->request->post()))) {
			if($model->save()) {
				Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan.');
				return $this->redirect(['print', 'id' => $model->id]);
			} else {
				Yii::$app->session->setFlash('error', 'Transaksi gagal disimpan.');
			}
		}

		return $this->render('add', [
			'model' => $model,
			'akun' => $akun,
		]);
	}

	public function actionPrint($id) {
		$model = $this->findModel($id);

		return $this->render('print', [
			'model' => $model,
		]);
	}

	public function actionAkun() {
		$model = new Akun();

		if((Yii::$app->request->isPost) && ($model->load(Yii::$app->request->post()))) {
			$model->harga = 0;
			if($model->save()) {
				Yii::$app->session->setFlash('success', 'Akun berhasil disimpan.');
			} else {
				Yii::$app->session->setFlash('error', 'Akun gagal disimpan.');
			}
			$model = new Akun();
		}

		$akun = Akun::queryLeaf();

		return $this->render('akun', [
			'akun' => $akun,
			'model' => $model,
		]);
	}

	public function actionListunconfirmed() {
		$dataProvider = new ActiveDataProvider([
			'query' => Transaksi::find()
						->where('confirmed=0'),
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $this->render('listunconfirmed', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionNewconfirm($id) {
		$session = new Session();
		$session->open();

		$session->set('transaksi', []);

		return $this->redirect(['confirm', 'id'=>$id], 302);
	}

	public function actionConfirm($id) {
		$session = new Session();
		$session->open();

		$listTransaksi = $session->get('transaksi');

		$transaksi = Transaksi::findOne($id);
		if($transaksi->jenis_periode == "periode") {
			$siarans = $transaksi->getSiarans()->limit($transaksi->siaran_per_hari)->all();
		} else {
			$siarans = $transaksi->getSiarans()->all();
		}
		$confirmationForm = new ConfirmationForm();
		$akun = Akun::find()->all();

		if((Yii::$app->request->isPost) && ($confirmationForm->load(Yii::$app->request->post()))) {
			if($confirmationForm->validate()) {
				$listTransaksi[] = $confirmationForm;
				$session->set('transaksi', $listTransaksi);
			} else {
				Yii::$app->session->setFlash('error', 'Input tidak valid.');
			}
		}

		return $this->render('confirm', [
			'transaksi' => $transaksi,
			'siarans' => $siarans,
			'akun' => $akun,
			'confirmationForm' => $confirmationForm,
			'listTransaksi' => $listTransaksi,
		]);
	}

	public function actionDoconfirm($id) {
		$session = new Session();
		$session->open();

		$listTransaksi = $session->get('transaksi');
		$transaksi = Transaksi::findOne($id);

		$debit = 0;
		$kredit = 0;

		foreach ($listTransaksi as $data) {
			if($data->jenis_transaksi == "debit") {
				$debit += $data->nominal;
			} else {
				$kredit += $data->nominal;
			}
		}

		if(($debit == $kredit) && ($debit == $transaksi->nominal)) {
			foreach ($listTransaksi as $data) {
				$transaksiLain = TransaksiLainFactory::createTransaksiLainFromConfirmation($transaksi, $data);
				$transaksiLain->save();
			}

			$transaksi->confirmed = 1;
			$transaksi->save();
			Yii::$app->session->setFlash('success', 'transaksi berhasil dikonfirmasi');
			return $this->redirect('listunconfirmed', 302);
		} else {
			Yii::$app->session->setFlash('error', 'Jumlah debit, kredit, dan nominal transaksi belum sama.');
			return $this->redirect(['confirm', 'id'=>$id], 302);
		}
	}

	public function actionListtransaction($date = "") {
		$listTransaksi = TransaksiLain::find();

		if($date != "") {
			$listTransaksi = $listTransaksi->where('tanggal="' . $date . '"');
		}
		$listTransaksi = $listTransaksi->orderBy(['tanggal' => SORT_ASC])->with('akun');

		$dataProvider = new ActiveDataProvider([
			'query' => $listTransaksi,
			'pagination' => [
				'pageSize' => 15,
			]
		]);

		return $this->render('listtransaction', [
			'date' => $date,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$akun = Akun::find()->all();

		if((Yii::$app->request->isPost) && ($model->load(Yii::$app->request->post()))) {
			if($model->save()) {
				Yii::$app->session->setFlash('success', 'Transaksi berhasil diubah.');
			} else {
				Yii::$app->session->setFlash('error', 'Transaksi gagal diubah.');
			}
		}

		return $this->render('update', [
			'model' => $model,
			'akun' => $akun,
		]);
	}

	protected function findModel($id) {
        if (($model = TransaksiLain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
