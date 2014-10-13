<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\form\LoginForm;
use app\models\ContactForm;
use app\models\db\User;
use app\models\db\Siaran;
use app\models\form\ChangePasswordForm;
use yii\web\Session;

class UserController extends Controller
{
    public $layout = '@app/views/layouts/sidebar';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['changepassword'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * @param int $id user id
     */
    public function actionChangepassword($id){
        if (Yii::$app->user->identity->id != $id){
            throw new HttpException(401);
        }
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post())){
            $model->id = Yii::$app->user->identity->id;
            $session = new Session(); $session->open();
            if ($model->validate() && $model->updatePassword()){
                $session->setFlash('message',"Ganti password berhasil");
            }       
        }
        return $this->render('changepassword',['model' => $model]);
    }
}
