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

class SiteController extends Controller
{
    public $layout = '@app/views/layouts/sidebar';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        if (!Yii::$app->user->isGuest){
            if ($user->isAdmin()){
                $this->redirect(['/adminradio']);
            } else if ($user->isDirektur()){
                $this->redirect(['/direktur']);
            } else if ($user->isManajerKeuangan()){
                $this->redirect(['/manajerkeuangan']);
            } else if ($user->isPetugas()){
                $this->redirect(['/petugas']);
            } else {
                throw new \yii\web\HttpException(401,"Akun anda tidak memiliki hak akses apapun. Silakan hubungi admin.");
            }
        } else {
            $this->redirect(['site/login']);
        }
    }

    public function actionLogin()
    {
        $this->layout = '@app/views/layouts/main';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $this->layout = '@app/views/layouts/main';
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        $this->layout = '@app/views/layouts/main';
        return $this->render('about');
    }
}
