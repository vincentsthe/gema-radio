<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\db\Transaksi;

class TransaksiForm extends Model {

	public $nama;
	public $tanggal;
	public $nominal;
	public $terbilang;
	public $deskripsi;
	public $no_order;
	public $jenis_transaksi;
	public $jenis_siaran;
	public $periode_awal;
	public $periode_akhir;
	public $siaran_per_hari;
	public $jumlah_siaran;
	public $interval;

	public function rules() {
		return [
			[['nama', 'tanggal', 'nominal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'jenis_periode'], 'required'],
			[['nama', 'tanggal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'periode_awal', 'periode_akhir', 'no_order'], 'string'],
			[['siaran_per_hari', 'jumlah_siaran', 'interval'], 'integer'],
			['siaran_per_hari', 'required', 'when' => function($model) {
				return ($model->jenis_siaran == "periodik");
			}, 'whenClient' => 'function(attribute, value) {
				return ($("#jenis_siaran").val == "periodik");
			}'],
			['interval', 'required', 'when' => function($model) {
				return ($model->jenis_siaran == "periodik");
			}, 'whenClient' => 'function(attribute, value) {
				return ($("#jenis_siaran").val == "periodik");
			}'],
			['jumlah_siaran', 'required', 'when' => function($model) {
				return ($model->jenis_siaran == "per_siaran");
			}, 'whenClient' => 'function(attribute, value) {
				return ($("#jenis_siaran").val == "per_siaran");
			}'],
		];
	}

}