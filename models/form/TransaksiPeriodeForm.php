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

}