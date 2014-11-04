<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\db\Transaksi;

class TransaksiSiaranForm extends Model {

	public $nama;
	public $tanggal;
	public $nominal;
	public $terbilang;
	public $deskripsi;
	public $no_order;
	public $jenis_periode;
	public $jenis_transaksi;
	public $jumlah_siaran;

	public function rules() {
		return [
			[['nama', 'tanggal', 'nominal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'jenis_periode', 'jumlah_siaran'], 'required'],
			[['nama', 'tanggal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'no_order'], 'string'],
			[['jumlah_siaran'], 'integer'],
		];
	}

}