<?php

namespace app\models\factory;

use app\models\db\TabunganHariTua;

class TabunganHariTuaFactory {

	public static function createTabunganHariTuaFromTransaksi($transaksi) {
		$tabungan = new TabunganHariTua();
		$tabungan->tanggal = $transaksi->tanggal;
		$tabungan->jenis_kegiatan = $transaksi->kegiatan;
		$tabungan->nominal = $transaksi->nominal;
		$tabungan->jenis_transaksi = $transaksi->jenis_transaksi;

		return $tabungan;
	}

}