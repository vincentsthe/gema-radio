<?php

namespace app\modules\manajerkeuangan\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use app\models\db\TabunganHariTua;

class TabunganHariTuaController extends BaseController {

	public function actionListtabungan($startDate="", $endDate="") {
		$query = TabunganHariTua::find();
		$debit = TabunganHariTua::getTotalDebit();
		$kredit = TabunganHariTua::getTotalKredit();

		if($startDate != "") {
			$query = $query->andWhere('tanggal>="' . $startDate . '"');
		}
		if($endDate != "") {
			$query = $query->andWhere('tanggal<="' . $endDate . '"');
		}
		$query = $query->orderBy(['tanggal' => SORT_ASC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 15,
			],
		]);

		return $this->render('listtabungan', [
			'dataProvider' => $dataProvider,
			'debit' => $debit,
			'kredit' => $kredit,
		]);
	}

	public function actionAdd() {
		$model = new TabunganHariTua();

		if((Yii::$app->request->isPost) && ($model->load(Yii::$app->request->post()))) {
			if($model->save()) {
				Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan.');
				return $this->redirect(['listtabungan']);
			} else {
				Yii::$app->session->setFlash('error', 'Transaksi gagal disimpan.');
			}
		}

		return $this->render('add', [
			'model' => $model,
		]);
	}

}