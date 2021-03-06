<?php

namespace app\models\factory;

use app\models\db\Transaksi;
use app\models\db\TransaksiLain;
use app\models\form\ConfirmationForm;

class TransaksiLainFactory {

	public function createTransaksiLainFromConfirmation($transaksi, $confirmationForm) {
		$transaksiLain = new TransaksiLain();
		$transaksiLain->kegiatan = $transaksi->jenis_transaksi;
		$transaksiLain->akun_id = $confirmationForm->akun_id;
		$transaksiLain->jenis_transaksi = $confirmationForm->jenis_transaksi;
		$transaksiLain->tanggal = $transaksi->tanggal;
		$transaksiLain->nominal = $confirmationForm->nominal;
		$transaksiLain->terbilang = $confirmationForm->terbilang;
		$transaksiLain->deskripsi = $confirmationForm->deskripsi;

		return $transaksiLain;
	}

}