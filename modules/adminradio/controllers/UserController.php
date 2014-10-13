<?php

namespace app\modules\adminradio\controllers;

use yii\web\Controller;
use app\models\db\User;
use yii\data\ActiveDataProvider;

class UserController extends BaseController
{
    public function actionIndex()
    {
    	$dataProvider = new ActiveDataProvider([
            'query' => User::find()
        ]);
        return $this->render('index',[
        	'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param int $id user id
     */
    public function actionResetpassword($id){
    	$model = $this->loadModel($id);
    	$model->password = sha1($model->username);

    	if ($model->save()){
    		return $this->render('resetpassword',[
    			'model' => $model,
    		]);
    	}
    	
    }

    /**
     * @param int $id user id
     * @throws NotFoundHttpException
     */
    protected function loadModel($id){
    	if (($model = User::find()->where(['id' => $id])->one()) !== null){
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
}
