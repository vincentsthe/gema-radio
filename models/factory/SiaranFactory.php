<?php

namespace app\models\factory;

use app\models\db\Siaran;

class SiaranFactory {

	public function createSiaranFromInput($tanggal, $waktuMulai, $waktuSelesai, $transaksiId) {
		$siaran = new Siaran();
		$siaran->tanggal = $tanggal;
		$siaran->waktu_mulai = $waktuMulai;
		$siaran->waktu_selesai = $waktuSelesai;
		$siaran->transaksi_id = $transaksiId;

		return $siaran;
	}

}