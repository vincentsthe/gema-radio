<?php

namespace app\modules\petugas\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use app\models\db\Transaksi;
use app\models\form\TransaksiForm;
use app\models\factory\RekamanFactory;
use app\models\factory\SiaranFactory;

class TransaksiController extends BaseController {

	public function actionCreatenewtransaksi() {
		$session = new Session;
		$session->open();

		$transaksi = new Transaksi();
		$session->set('transaksi', $transaksi);
		$session->set('siaran', []);
		$session->close();
		return $this->redirect('createtransaksi', 302);
	}

	public function actionCreatetransaksi($request = 'transaksi') {
		$session = new Session;
		$session->open();

		if($session->get('transaksi') === NULL) {
			return $this->redirect('createnewtransaksi', 302);
		}
		
		if($request == 'siaran') {
			$siaran = $session->get('siaran');
			Yii::$app->response->format = 'json';
			return $siaran;
		}

		$model = $session->get('transaksi');

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			$model->akun_id = 1;

			if($model->validate()) {
/*				$siarans = Yii::$app->request->post('Siaran');

				$session->set('transaksiForm', $model);
				$session->set('siaran', $siarans); */ //TODO

				return $this->redirect('preview', 302);
			} else {
				Yii::$app->session->setFlash('error', 'Data tidak valid, masukan data lagi.');
			}
		}

        return $this->render('createtransaksi', [
            'model' => $model,
        ]);
	}

	public function actionPreview() {
		$session = new Session;
		$session->open();

		$transaksiForm = $session->get('transaksiForm');
		$siarans = $session->get('siaran');

		return $this->render('preview', [
			'transaksi' => $transaksi,
			'siarans' => $siarans,
		]);
	}

	//TODO: not yet adapt transaksiForm (still Transaksi Model now)
	public function actionSave() {
		$session = new Session;
		$session->open();

		$transaksi = $session->get('transaksi');
		$siarans = $session->get('siaran');

		if($transaksi->save()) {
			foreach($siarans as $siaran) {
				if($transaksi->haveSiaran()) {
					$siaran = SiaranFactory::createSiaranFromInput($siaran['tanggal'], $siaran['waktu'] . ":00", $transaksi->id);
					$siaran->save();
				}
				if($transaksi->haveRekaman()) {
					$rekaman = RekamanFactory::createRekamanFromInput($siaran['tanggal'], $siaran['waktu'] . ":00", $transaksi->id);
					$rekaman->save();
				}
			}
			Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan.');
		} else {
			Yii::$app->session->setFlash('error', 'Terjadi error, masukan ulang data transaksi.');
		}

		return $this->redirect('print', 302);
	}

	//TODO: same above
	public function actionPrint() {
		$session = new Session;
		$session->open();

		$transaksi = $session->get('transaksi');
		$siarans = $session->get('siaran');

		return $this->render('print', [
			'transaksi' => $transaksi,
			'siarans' => $siarans,
		]);
	}

}