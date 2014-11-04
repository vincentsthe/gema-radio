<?php

namespace app\models\form;

use Yii;
use yii\base\Model;

class ConfirmationForm extends Model {

	public $akun_id;
	public $jenis_transaksi;
	public $nominal;
	public $terbilang;

	public function rules() {
		return [
			[['akun_id', 'jenis_transaksi', 'nominal', 'terbilang'], 'required'],
			[['nominal'], 'integer'],
		];
	}

}