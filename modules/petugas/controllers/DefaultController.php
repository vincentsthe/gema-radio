<?php

namespace app\modules\petugas\controllers;

use Yii;
use yii\web\Controller;
use app\models\db\Transaksi;
use app\models\form\ChangePasswordForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

class DefaultController extends Controller
{
	public $layout = '@app/views/layouts/sidebar';

	public function actionCreatetransaksi() {
		$model = new Transaksi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('createTransaksi', [
                'model' => $model,
            ]);
        }
	}

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionChangepassword() {
        $model = new ChangePasswordForm();
        if (!isset(Yii::$app->user->identity->id)) {
            throw new HttpException(401);
        }

        if ($model->load(Yii::$app->request->post())){
            $model->id = Yii::$app->user->identity->id;
            $session = new Session(); $session->open();
            if ($model->validate() && $model->updatePassword()){
                $session->setFlash('success',"Ganti password berhasil");
            }       
        }
        return $this->render('changepassword',['model' => $model]);
    }
}
