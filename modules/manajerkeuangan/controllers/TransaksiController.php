<?php

namespace app\modules\manajerkeuangan\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

use app\models\db\Transaksi;
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
    	$model = new TransaksiSearch;
    	$dataProvider = $model->search(Yii::$app->request->queryParams);

        return $this->render('index',[
        	'model' => $model,
        	'akuns' => $akuns,
        	'dataProvider' => $dataProvider,
        ]);
    }
}
