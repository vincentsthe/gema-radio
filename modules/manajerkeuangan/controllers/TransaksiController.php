<?php

namespace app\modules\manajerkeuangan\controllers;

use app\models\db\Siaran;
use app\models\form\TransaksiPeriodeForm;
use app\models\form\TransaksiSiaranForm;
use app\modules\manajerkeuangan\models\form\TransaksiSearchForm;
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
use app\models\factory\TransaksiFactory;
use app\models\factory\TransaksiLainFactory;
use app\models\factory\SiaranFactory;
use app\models\factory\RekamanFactory;
use app\helpers\TimeHelper;
use app\models\search\TransaksiSearch;

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

	public function actionNewadd() {
		$session = new Session();
		$session->open();

		$session->set('transaksi', []);

		return $this->redirect(['add']);
	}

	public function actionAdd() {
		$session = new Session();
		$session->open();

		$model = new TransaksiLain();
		$akuns = Akun::getLeafs();

		if((Yii::$app->request->isPost) && ($model->load(Yii::$app->request->post()))) {
			if($model->validate()) {
				Yii::$app->session->setFlash('success', 'Transaksi ditambahkan.');
				$transaction = $session->get('transaksi');
				$transaction[] = $model;
				$session->set('transaksi', $transaction);
				$model = new TransaksiLain();
			} else {
				Yii::$app->session->setFlash('error', 'Transaksi gagal disimpan.');
			}
		}

		$transaction = $session->get('transaksi');

		return $this->render('add', [
			'model' => $model,
			'akun' => $akuns,
			'transaction' => $transaction,
		]);
	}

	public function actionDoadd() {
		$session = new Session();
		$session->open();

		$transactions = $session->get('transaksi');
		$sum = 0;
		foreach($transactions as $transaction) {
			if($transaction->jenis_transaksi == "debit") {
				$sum += $transaction->nominal;
			} else {
				$sum -= $transaction->nominal;
			}
		}

		if($sum != 0) {
			Yii::$app->session->setFlash('error', 'Jumlah debit dan kredit belum sama.');
			return $this->redirect(['add']);
		} else {
			foreach($transactions as $transaction) {
				$transaction->save();
			}
			Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan.');
			return $this->redirect(['newadd']);
		}
	}

	public function actionPrint($id) {
		$model = $this->findModel($id);

		return $this->render('print', [
			'model' => $model,
		]);
	}

	public function actionEditAkun($id){
		$model = Akun::findOne($id);
		if ($model === null){
			throw new \yii\web\HttpException(404, 'Akun tidak ditemukan.');
		}
		if ($model->load(Yii::$app->request->post()) ) {
			if ($model->save()){
				Yii::$app->session->setFlash('success','Akun berhasil diubah');
				$this->redirect('akun');
			}
			else
				Yii::$app->session->setFlash('error','Akun gagal diubah');
		}
		return $this->render('edit-akun',[
			'model' => $model]);
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
			'query' => Transaksi::find()->
				where(['not', ['and', ['confirmed' => 1], ['<','tanggal',TimeHelper::getTodayDate()]]]),
				//		->orWhere('confirmed=0')
				//		->orWhere('date_confirmed="' . TimeHelper::getTodayDate() . '"'),
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		return $this->render('listunconfirmed', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionListedit() {
		$searchModel = new TransaksiSearch(['scenario'=>'filtertanggal']);
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	/*
		$dataProvider = new ActiveDataProvider([
			'query' => Transaksi::find()
				->where('confirmed=0'),
			'pagination' => [
				'pageSize' => 10,
			],
		]);*/

		return $this->render('listedit', [
			'dataProvider' => $dataProvider,
			'model' => $searchModel,
		]);
	}

	public function actionListtransaction($date = "") {
		$listTransaksi = TransaksiLain::find();
		$form = new TransaksiSearchForm();
		$akuns = Akun::find()->all();

		if ($form->load(\Yii::$app->request->get()) && $form->validate()) {
		}

		if($form->akun_id != "") {
			$listTransaksi->andWhere('akun_id=' . $form->akun_id);
		}

		if($form->tanggal_awal != "") {
			$listTransaksi->andWhere('tanggal>="' . $form->tanggal_awal . '"');
			$listTransaksi->andWhere('tanggal<="' . $form->tanggal_akhir . '"');
		}

		$listTransaksi = $listTransaksi->orderBy(['tanggal' => SORT_ASC])->with('akun');

		$dataProvider = new ActiveDataProvider([
			'query' => $listTransaksi,
			'pagination' => [
				'pageSize' => 15,
			],
		]);

		return $this->render('listtransaction', [
			'date' => $date,
			'dataProvider' => $dataProvider,
			'model' => $form,
			'akuns' => $akuns,
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
				$confirmationForm = new ConfirmationForm();
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
			$transaksi->date_confirmed = TimeHelper::getTodayDate();
			$transaksi->save();
			Yii::$app->session->setFlash('success', 'transaksi berhasil dikonfirmasi');
			return $this->redirect('listunconfirmed', 302);
		} else {
			Yii::$app->session->setFlash('error', 'Jumlah debit, kredit, dan nominal transaksi belum sama.');
			return $this->redirect(['confirm', 'id'=>$id], 302);
		}
	}

	public function actionEdit($id) {
		$session = new Session();
		$session->open();

		$transaksi = Transaksi::findOne($id);

		if($transaksi->jenis_periode == "siaran") {
			$transaksiSiaranForm = new TransaksiSiaranForm();
			$transaksiSiaranForm->fillFromTransaksi($transaksi);
			$session->set('transaksi', $transaksiSiaranForm);

			if($transaksi->haveSiaran()) {
				$listSiaran = $transaksi->siarans;
			} else {
				$listSiaran = $transaksi->rekaman;
			}

			$siarans = array();
			foreach($listSiaran as $siaran) {
				$record = array();
				$record['tanggal'] = $siaran->tanggal;
				$record['jam'] = substr($siaran->waktu, 0, 5);

				$siarans[] = $record;
			}

			$session->set('siarans',  $siarans);
			return $this->redirect(['editsiaran', 'id'=>$id], 302);
		} else {
			$transaksiPeriodeForm = new TransaksiPeriodeForm();
			$transaksiPeriodeForm->fillFromTransaksi($transaksi);
			$session->set('transaksi', $transaksiPeriodeForm);

			if($transaksi->haveSiaran()) {
				$listSiaran = Siaran::find()
								->where('transaksi_id='.$transaksi->id)
								->limit($transaksi->siaran_per_hari)
								->all();
			} else {
				$listSiaran = Rekaman::find()
								->where('transaksi_id='.$transaksi->id)
								->limit($transaksi->siaran_per_hari)
								->all();
			}

			$siarans = array();
			foreach($listSiaran as $siaran) {
				$record = array();
				$record['jam'] = substr($siaran->waktu, 0, 5);

				$siarans[] = $record;
			}

			$session->set('siarans',  $siarans);
			return $this->redirect(['editperiode', 'id'=>$id], 302);
		}
	}

	public function actionEditsiaran($id = 0, $request = "transaksi") {
		$session = new Session();
		$session->open();

		$transaksiForm = $session->get('transaksi');
		$siarans = $session->get('siarans');

		if($request == 'siaran') {
			Yii::$app->response->format = 'json';
			return $siarans;
		}

		$model = $transaksiForm;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());

			if($model->validate()) {
				$transaksi = Transaksi::findOne($id);
				$transaksi->fillFromSiaranForm($model);

				$siarans = Yii::$app->request->post('Siaran');

				if($transaksi->update(false)) {
					foreach ($siarans as $siaran) {
						if ($transaksi->haveSiaran()) {
							$listSiaran = $transaksi->siarans;
							foreach($listSiaran as $record) {
								$record->delete();
							}

							$siaran = SiaranFactory::createSiaranFromInput($siaran['tanggal'], $siaran['jam'] . ":00", $transaksi->id);
							$siaran->save();
						}
						if ($transaksi->haveRekaman()) {
							$listRekaman = $transaksi->rekaman;
							foreach($listRekaman as $record) {
								$record->delete();
							}

							$rekaman = RekamanFactory::createRekamanFromInput($siaran['tanggal'], $siaran['jam'] . ":00", $transaksi->id);
							$rekaman->save();
						}
					}
					Yii::$app->session->setFlash('success', 'Transaksi berhasil diedit.');
					return $this->redirect(['edit', 'id' => $id]);
				} else {
					Yii::$app->session->setFlash('error', 'Transaksi gagal diedit.');
				}
			} else {
				Yii::$app->session->setFlash('error', 'Data tidak valid, masukan data lagi.');
			}
		}

		return $this->render('edittransaksisiaran', [
			'model' => $model,
		]);
	}

	public function actionEditperiode($id = 0, $request = "transaksi") {
		$session = new Session();
		$session->open();

		$transaksiForm = $session->get('transaksi');
		$siarans = $session->get('siarans');

		if($request == 'siaran') {
			Yii::$app->response->format = 'json';
			return $siarans;
		}

		$model = $transaksiForm;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());

			if($model->validate()) {
				$transaksi = Transaksi::findOne($id);
				$transaksi->fillFromPeriodeForm($model);

				$siarans = Yii::$app->request->post('Siaran');

				if($transaksi->update(false)) {
					if ($transaksi->haveSiaran()) {
						$listSiaran = $transaksi->siarans;
						foreach ($listSiaran as $record) {
							$record->delete();
						}
					}
					if ($transaksi->haveRekaman()) {
						$listRekaman = $transaksi->rekaman;
						foreach ($listRekaman as $record) {
							$record->delete();
						}
					}

					$tanggal = $transaksi->periode_awal;
					while (TimeHelper::compareFirstDate($tanggal, $transaksi->periode_akhir)) {
						foreach ($siarans as $siaran) {
							if ($transaksi->haveSiaran()) {
								$siaran = SiaranFactory::createSiaranFromInput($tanggal, $siaran['jam'] . ":00", $transaksi->id);
								$siaran->save();
							}
							if ($transaksi->haveRekaman()) {
								$rekaman = RekamanFactory::createRekamanFromInput($tanggal, $siaran['jam'] . ":00", $transaksi->id);
								$rekaman->save();
							}
						}
						for ($i = 0; $i < $transaksi->frekuensi; $i++) {
							$tanggal = TimeHelper::getTomorrowDate($tanggal);
						}
					}
					Yii::$app->session->setFlash('success', 'Transaksi berhasil diedit.');
					return $this->redirect(['edit', 'id' => $id]);
				} else {
					Yii::$app->session->setFlash('error', 'Transaksi gagal diedit.');
				}
			} else {
				var_dump($model->errors);
				exit;
				Yii::$app->session->setFlash('error', 'Data tidak valid, masukan data lagi.');
			}
		}

		return $this->render('edittransaksiperiode', [
			'model' => $model,
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

	public function actionPrinttabungan($startDate, $endDate,$akunId) {
		$query = TabunganHariTua::find();
		$debit = TabunganHariTua::getTotalDebit();
		$kredit = TabunganHariTua::getTotalKredit();

		if($debit >= $kredit) {
			$debit -= $kredit;
			$kredit = 0;
		} else {
			$debit = 0;
			$kredit -= $debit;
		}

		if($startDate != "") {
			$query = $query->andWhere('tanggal>="' . $startDate . '"');
		}
		if($endDate != "") {
			$query = $query->andWhere('tanggal<="' . $endDate . '"');
		}
		$data = $query->orderBy(['tanggal' => SORT_ASC])->all();

		$output = fopen('php://output', 'w');

		fputcsv($output, ['Tanggal', 'Jenis Kegiatan', 'Debit', 'Kredit']);

		foreach ($data as $record) {
			$recordDebit = 0;
			$recordKredit = 0;
			if($record->jenis_transaksi == "debit") {
				$recordDebit = $record->nominal;
			} else {
				$recordKredit = $record->nominal;
			}

			fputcsv($output, [$record->tanggal, $record->jenis_kegiatan, $recordDebit, $recordKredit]);
		}

		fputcsv($output, []);
		fputcsv($output, ['', '', 'Saldo Debit', $debit]);
		fputcsv($output, ['', '', 'Saldo Kredit', $kredit]);

		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename=tes.csv');
	}

	protected function findModel($id) {
        if (($model = TransaksiLain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
