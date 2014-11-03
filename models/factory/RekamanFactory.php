<?php

namespace app\models\factory;

use app\models\db\Rekaman;

class RekamanFactory {
	public static function createRekamanFromInput($tanggal, $waktu, $transaksiId) {
		$rekaman = new Rekaman();
		$rekaman->tanggal = $tanggal;
		$rekaman->waktu = $waktu;
		$rekaman->transaksi_id = $transaksiId;

		return $rekaman;
	}
}