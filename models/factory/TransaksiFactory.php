<?php

namespace app\models\factory;

use app\models\db\Transaksi;
use app\models\form\TransaksiSiaranForm;

class TransaksiFactory {

	public static function createTransaksiFromTransaksiSiaranForm($transaksiSiaranForm) {
		$transaksi = new Transaksi;
		$transaksi->nama = $transaksiSiaranForm->nama;
		$transaksi->tanggal = $transaksiSiaranForm->tanggal;
		$transaksi->nominal = $transaksiSiaranForm->nominal;
		$transaksi->terbilang = $transaksiSiaranForm->terbilang;
		$transaksi->deskripsi = $transaksiSiaranForm->deskripsi;
		$transaksi->no_order = $transaksiSiaranForm->no_order;
		$transaksi->jenis_periode = $transaksiSiaranForm->jenis_periode;
		$transaksi->jenis_transaksi = $transaksiSiaranForm->jenis_transaksi;
		$transaksi->jumlah_siaran = $transaksiSiaranForm->jumlah_siaran;

		return $transaksi;
	}

	public static function createTransaksiFromTransaksiPeriodeForm($transaksiPeriodeForm) {
		$transaksi = new Transaksi;
		$transaksi->nama = $transaksiPeriodeForm->nama;
		$transaksi->tanggal = $transaksiPeriodeForm->tanggal;
		$transaksi->nominal = $transaksiPeriodeForm->nominal;
		$transaksi->terbilang = $transaksiPeriodeForm->terbilang;
		$transaksi->deskripsi = $transaksiPeriodeForm->deskripsi;
		$transaksi->no_order = $transaksiPeriodeForm->no_order;
		$transaksi->jenis_periode = $transaksiPeriodeForm->jenis_periode;
		$transaksi->jenis_transaksi = $transaksiPeriodeForm->jenis_transaksi;
		$transaksi->siaran_per_hari = $transaksiPeriodeForm->siaran_per_hari;
		$transaksi->frekuensi = $transaksiPeriodeForm->frekuensi;
		$transaksi->periode_awal = $transaksiPeriodeForm->periode_awal;
		$transaksi->periode_akhir = $transaksiPeriodeForm->periode_akhir;

		return $transaksi;
	}

}