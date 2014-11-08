<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\db\Transaksi;

class TransaksiPeriodeForm extends Model {

	public $nama;
	public $tanggal;
	public $nominal;
	public $terbilang;
	public $deskripsi;
	public $no_order;
	public $jenis_periode;
	public $jenis_transaksi;
	public $siaran_per_hari;
	public $frekuensi;
	public $periode_awal;
	public $periode_akhir;

	public function rules() {
		return [
			[['nama', 'tanggal', 'nominal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'jenis_periode', 'siaran_per_hari', 'periode_awal', 'periode_akhir', 'frekuensi'], 'required'],
			[['nama', 'tanggal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'no_order', 'periode_awal', 'periode_akhir'], 'string'],
			[['siaran_per_hari'], 'integer'],
		];
	}

	public function fillFromTransaksi($transaksi) {
		$this->nama = $transaksi->nama;
		$this->tanggal = $transaksi->tanggal;
		$this->nominal = $transaksi->nominal;
		$this->terbilang = $transaksi->terbilang;
		$this->deskripsi = $transaksi->deskripsi;
		$this->no_order = $transaksi->no_order;
		$this->jenis_periode = $transaksi->jenis_periode;
		$this->jenis_transaksi = $transaksi->jenis_transaksi;
		$this->siaran_per_hari = $transaksi->siaran_per_hari;
		$this->frekuensi = $transaksi->frekuensi;
		$this->periode_awal = $transaksi->periode_awal;
		$this->periode_akhir = $transaksi->periode_akhir;
	}

}