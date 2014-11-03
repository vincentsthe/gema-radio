<?php

namespace app\models\factory;

use app\models\db\Siaran;

class SiaranFactory {

	public function createSiaranFromInput($tanggal, $waktu, $transaksiId) {
		$siaran = new Siaran();
		$siaran->tanggal = $tanggal;
		$siaran->waktu = $waktu;
		$siaran->transaksi_id = $transaksiId;

		return $siaran;
	}

}