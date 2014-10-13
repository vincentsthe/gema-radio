<?php

namespace app\modules\adminradio\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\form\ChangePasswordForm;
use Yii;
use yii\web\Session;

class UserController extends BaseController
{
    public function actionGantipassword()
    {
    	$model = new ChangePasswordForm();
    	//var_dump(Yii::$app->user);
    	//return $this->render('gantipassword',['model' => $model]);
    	if ($model->load(Yii::$app->request->post())){
    		$model->id = Yii::$app->user->identity->id;
    		$session = new Session(); $session->open();
    		if ($model->validate() && $model->updatePassword()){
    			$session->setFlash('message',"Ganti password berhasil");
    		}		
    	}
        return $this->render('gantipassword',['model' => $model]);
    }
}
