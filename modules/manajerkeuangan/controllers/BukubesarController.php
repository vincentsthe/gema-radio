<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

use app\models\db\Transaksi;
use app\modules\manajerkeuangan\models\form\BukuBesarForm;


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
    	$model = new BukuBesarForm;
    	/*
    	$dataProvider = new ActiveDataProvider([
    		'query' => Transaksi::queryBukuBesar($akun_id,$tanggal_mulai,$tanggal_selesai)
    	]);*/
        return $this->render('index',[
        	'model' => $model,
        	//'dataProvider' => $dataProvider,
        ]);
    }
}
