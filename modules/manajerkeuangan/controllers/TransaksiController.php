<?php

namespace app\modules\manajerkeuangan\controllers;

use Yii;

use app\models\db\Akun;
use app\models\db\TransaksiLain;

class TransaksiController extends BaseController {

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
