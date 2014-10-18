<?php

namespace app\models\form;

use Yii;
use yii\base\Model;

class ConfirmationForm extends Model {

	public $akun_id;
	public $jenis_transaksi;

	public function rules() {
		return [
			[['akun_id', 'jenis_transaksi'], 'required']
		];
	}

}