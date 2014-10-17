<?php

namespace app\modules\manajerkeuangan\controllers;

class BukubesarController extends BaseController
{

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

use app\models\db\Transaksi;
use app\models\db\Akun;
use app\models\db\TransaksiLain;
use app\modules\manajerkeuangan\models\BukuBesar;

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

	protected function findModel($id) {
        if (($model = TransaksiLain::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
