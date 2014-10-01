<?php

namespace app\modules\petugas\controllers;

use Yii;
use yii\web\Controller;
use app\models\db\Transaksi;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
}
