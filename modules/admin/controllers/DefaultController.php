<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\models\db\Siaran;
use yii\data\ActiveDataProvider;

class DefaultController extends Controller
{
	public $layout = '@app/views/layouts/sidebar';

	public function actionSiaran() {
		$dataProvider = new ActiveDataProvider([		//TODO ganti ini sehinga hanya menampilkan siaran hari ini saja
            'query' => Siaran::find(),					//ini harus join sama tabel transaksi buat dapetin produk-nya
        ]);												//kode-nya dari mana??

		return $this->render('siaran', [
            'dataProvider' => $dataProvider,
        ]);
		return $this->render('siaran');
	}

    public function actionIndex()
    {
        return $this->render('index');
    }
}
