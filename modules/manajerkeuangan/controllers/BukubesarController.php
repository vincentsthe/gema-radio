<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

use app\models\db\Transaksi;
use app\models\db\TransaksiLain;
use app\models\db\Akun;
use app\modules\manajerkeuangan\models\BukuBesar;


class BukubesarController extends BaseController
{
	public $defaultAction = 'index';
	

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

    public function actionIndex()
    {
    	$model = new BukuBesar;
    	$akuns = Akun::find()->all();
    	$dataProvider = $model->search(Yii::$app->request->queryParams);
    	$params = Yii::$app->request->queryParams;

    	//hitung saldo dari awal banget sampe sebelum tanggal
    	$debet = TransaksiLain::find()
    		->andWhere(['<','tanggal',$params['BukuBesar']['tanggal_awal']])
    		->andWhere(['jenis_transaksi'=>TransaksiLain::DEBIT])
    		->sum('nominal'); 
    	if ($debet === null) $debet = 0;
    	$kredit = TransaksiLain::find()
    		->andWhere(['<','tanggal',$params['BukuBesar']['tanggal_awal']])
    		->andWhere(['jenis_transaksi'=>TransaksiLain::KREDIT])
    		->sum('nominal');
    	if ($kredit === null) $kredit = 0;
        return $this->render('index',[
        	'model' => $model,
        	'akuns' => $akuns,
        	'dataProvider' => $dataProvider,
        	'debet' => $debet,
        	'kredit' => $kredit
        ]);
    }
}
