<?php

namespace app\modules\manajerkeuangan\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

use app\models\db\TabunganHariTua;


use app\helpers\TimeHelper;

class TabunganHariTuaController extends BaseController {
	public function actionListtabungan($startDate,$endDate){
		$query = TabunganHariTua::find();
		$debit = TabunganHariTua::getTotalDebit();
		$kredit = TabunganHariTua::getTotalKredit();

		if($debit >= $kredit) {
			$debit -= $kredit;
			$kredit = 0;
		} else {
			$debit = 0;
			$kredit -= $debit;
		}

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
			'startDate' => $startDate,
			'endDate' => $endDate,
		]);
	}

	public function actionPrinttabungan($startDate, $endDate) {
		$query = TabunganHariTua::find();
		$debit = TabunganHariTua::getTotalDebit();
		$kredit = TabunganHariTua::getTotalKredit();

		if($debit >= $kredit) {
			$debit -= $kredit;
			$kredit = 0;
		} else {
			$debit = 0;
			$kredit -= $debit;
		}

		if($startDate != "") {
			$query = $query->andWhere('tanggal>="' . $startDate . '"');
		}
		if($endDate != "") {
			$query = $query->andWhere('tanggal<="' . $endDate . '"');
		}
		$data = $query->orderBy(['tanggal' => SORT_ASC])->all();

		$output = fopen('php://output', 'w');

		fputcsv($output, ['Tanggal', 'Jenis Kegiatan', 'Debit', 'Kredit']);
		//fputs($output,implode("\t", ['Tanggal', 'Jenis Kegiatan', 'Debit', 'Kredit']).'\\r\\n');
		foreach ($data as $record) {
			$recordDebit = 0;
			$recordKredit = 0;
			if($record->jenis_transaksi == "debit") {
				$recordDebit = $record->nominal;
			} else {
				$recordKredit = $record->nominal;
			}
			//fputs($output,implode("\t",[$record->tanggal, $record->jenis_kegiatan, $recordDebit, $recordKredit]).'\\r\\n');
			fputcsv($output, [$record->tanggal, $record->jenis_kegiatan, $recordDebit, $recordKredit]);
		}
		//fputs($output,implode("\t",[]).'\r\n');
		fputcsv($output, []);
		//fputs($output,implode('\t',['','','Saldo Debit',$debit,]).'\\r\\n');
		fputcsv($output, ['', '', 'Saldo Debit', $debit]);
		//fputs($output,implode('\t',['','','Saldo kredit',$kredit]).'\\r\\n');
		//fputcsv($output, ['', '', 'Saldo Kredit', $kredit]);

		header('Content-type: application/xlsx');
		header('Content-Disposition: attachment; filename=tabungan-hari-tua.csv');
	}

	public function actionAdd() {
		$model = new TabunganHariTua();

		if((Yii::$app->request->isPost) && ($model->load(Yii::$app->request->post()))) {
			if($model->save()) {
				Yii::$app->session->setFlash('success', 'Transaksi berhasil disimpan.');
				return $this->redirect(['listtabungan','startDate'=>'2014-01-01','endDate'=>'2014-12-31']);
			} else {
				Yii::$app->session->setFlash('error', 'Transaksi gagal disimpan.');
			}
		}

		return $this->render('add', [
			'model' => $model,
		]);
	}

}