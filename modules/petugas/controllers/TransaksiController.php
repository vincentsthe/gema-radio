<?php

namespace app\modules\petugas\controllers;

use Yii;
use yii\web\Controller;
use app\models\db\Transaksi;
use app\models\factory\SiaranFactory;

class TransaksiController extends BaseController {

	public function actionCreatetransaksi() {
		$model = new Transaksi();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());

			if($model->validate()) {
				$model->save(false);
				$siarans = Yii::$app->request->post('Siaran');

				$siaranFactory = new SiaranFactory();
				foreach ($siarans as $siaranInfo) {
					$siaran = $siaranFactory->createSiaranFromInput($siaranInfo['tanggal'], $siaranInfo['jamMulai'], $siaranInfo['jamSelesai'], $model->id);
					$siaran->save();
				}
				Yii::$app->session->setFlash('success', 'Data berhasil dimasukkan.');
			} else {
				Yii::$app->session->setFlash('error', 'Data tidak valid, masukan data lagi.');
			}
		}

        return $this->render('createtransaksi', [
            'model' => $model,
        ]);
	}

}