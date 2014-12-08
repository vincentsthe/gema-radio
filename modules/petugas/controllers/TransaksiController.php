<?php

namespace app\modules\petugas\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;
use app\helpers\TimeHelper;
use app\models\db\Transaksi;
use app\models\form\TransaksiPeriodeForm;
use app\models\form\TransaksiSiaranForm;
use app\models\factory\RekamanFactory;
use app\models\factory\SiaranFactory;
use app\models\factory\TransaksiFactory;

class TransaksiController extends BaseController {

	public function actionCreatenewtransaksisiaran() {
		$session = new Session;
		$session->open();

		$transaksiSiaranForm = new TransaksiSiaranForm();
		$session->set('transaksi', $transaksiSiaranForm);
		$session->set('siaran', []);
		$session->close();
		return $this->redirect('createtransaksisiaran', 302);
	}

	public function actionCreatetransaksisiaran($request = 'transaksi') {
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

			if($model->validate()) {
				$siarans = Yii::$app->request->post('Siaran');

				$session->set('transaksi', $model);
				$session->set('siaran', $siarans);

				return $this->redirect('preview', 302);
			} else {
				Yii::$app->session->setFlash('error', 'Data tidak valid, masukan data lagi.');
			}
		}

        return $this->render('createtransaksisiaran', [
            'model' => $model,
        ]);
	}

	public function actionCreatenewtransaksiperiode() {
		$session = new Session;
		$session->open();

		$transaksiPeriodeForm = new TransaksiPeriodeForm();
		$session->set('transaksi', $transaksiPeriodeForm);
		$session->set('siaran', []);
		$session->close();
		return $this->redirect('createtransaksiperiode', 302);
	}

	public function actionCreatetransaksiperiode($request = 'transaksi') {
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

			if($model->validate()) {
				if(!TimeHelper::compareFirstDate($model->periode_awal, $model->periode_akhir)) {
					Yii::$app->session->setFlash('error', 'Periode tidak valid.');
				} else {
					$siarans = Yii::$app->request->post('Siaran');

					$session->set('transaksi', $model);
					$session->set('siaran', $siarans);

					return $this->redirect('preview', 302);
				}
			} else {
				Yii::$app->session->setFlash('error', 'Data tidak valid, masukan data lagi.');
			}
		}

        return $this->render('createtransaksiperiode', [
            'model' => $model,
        ]);
	}

	public function actionPreview() {
		$session = new Session;
		$session->open();

		$transaksi = $session->get('transaksi');
		$siarans = $session->get('siaran');

		return $this->render('preview', [
			'transaksi' => $transaksi,
			'siarans' => $siarans,
		]);
	}

	public function actionSave() {
		$session = new Session;
		$session->open();

		$transaksiForm = $session->get('transaksi');
		$siarans = $session->get('siaran');

		if($transaksiForm->jenis_periode == "siaran") {
			$transaksi = TransaksiFactory::createTransaksiFromTransaksiSiaranForm($transaksiForm);
		} else if($transaksiForm->jenis_periode == "periode") {
			$transaksi = TransaksiFactory::createTransaksiFromTransaksiPeriodeForm($transaksiForm);
		}

		if($transaksi->save()) {
			if($transaksi->jenis_periode == "siaran") {
				foreach($siarans as $siaran) {
					if($transaksi->haveSiaran()) {
						$siarandb = SiaranFactory::createSiaranFromInput($siaran['tanggal'], $siaran['jam'] . ":00", $transaksi->id);
						$siarandb->save();
					}
					if($transaksi->haveRekaman()) {
						$rekamandb = RekamanFactory::createRekamanFromInput($siaran['tanggal'], $siaran['jam'] . ":00", $transaksi->id);
						$rekamandb->save();
					}
				}
			}
			if($transaksi->jenis_periode == "periode") {
				$tanggal = $transaksi->periode_awal;
				while (TimeHelper::compareFirstDate($tanggal, $transaksi->periode_akhir)) {
					foreach ($siarans as $siaran) {
						if($transaksi->haveSiaran()) {
							$siarandb = SiaranFactory::createSiaranFromInput($tanggal, $siaran['jam'] . ":00", $transaksi->id);
							$siarandb->save();
						}
						if($transaksi->haveRekaman()) {
							$rekamandb = RekamanFactory::createRekamanFromInput($tanggal, $siaran['jam'] . ":00", $transaksi->id);
							$rekamandb->save();
						}
					}
					for($i=0 ; $i<$transaksi->frekuensi ; $i++) {
						$tanggal = TimeHelper::getTomorrowDate($tanggal);
					}
				}
			}
			$session->set('transaksi', $transaksi);
			Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan.');
		} else {
			Yii::$app->session->setFlash('error', 'Terjadi error, masukan ulang data transaksi.');
			if($transaksiForm->jenis_periode == "siaran") {
				return $this->redirect('createtransaksisiaran', 302);
			}
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