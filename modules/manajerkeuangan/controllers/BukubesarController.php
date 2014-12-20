<?php

namespace app\modules\manajerkeuangan\controllers;

use app\helpers\TimeHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;

use app\models\db\Transaksi;
use app\models\db\TransaksiLain;
use app\models\db\Akun;
use app\modules\manajerkeuangan\models\BukuBesar;


class BukubesarController extends BaseController
{
	public $defaultAction = 'index';
	

	public function behaviors(){
		return ArrayHelper::merge([
			//allow access to direktur
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
						'matchCallback' => function($rule,$action){
							if (isset(Yii::$app->user->identity)){
								return Yii::$app->user->identity->isDirektur();
							}
							else
								return false;
						}		
					],
				]
			]
		],parent::behaviors());
	}

    public function actionIndex()
    {
    	$model = new BukuBesar;
		$model->tanggal_awal = TimeHelper::getBeginningYear(TimeHelper::getTodayDate());
		$model->tanggal_akhir = TimeHelper::getTodayDate();
		$model->akun_id = Akun::find()->where(['nama'=>'Kas'])->one()->id;
    	$akuns = Akun::getLeafs();
    	$dataProvider = $model->search(Yii::$app->request->queryParams);
    	$params = Yii::$app->request->queryParams;

    	$debet = 0; $kredit = 0;
    	//hitung saldo dari awal banget sampe sebelum tanggal
    	if (isset($params['BukuBesar'])){
    		$debet = TransaksiLain::find()
	    		->andWhere(['<','tanggal',$params['BukuBesar']['tanggal_awal']])
				->andWhere(['>', 'tanggal', TimeHelper::getBeginningYear(TimeHelper::getTodayDate())])
	    		->andWhere(['jenis_transaksi'=>TransaksiLain::DEBIT])
	    		->sum('nominal'); 
    		if ($debet === null) $debet = 0;
	    	$kredit = TransaksiLain::find()
	    		->andWhere(['<','tanggal',$params['BukuBesar']['tanggal_awal']])
				->andWhere(['>', 'tanggal', TimeHelper::getBeginningYear(TimeHelper::getTodayDate())])
	    		->andWhere(['jenis_transaksi'=>TransaksiLain::KREDIT])
	    		->sum('nominal');
	    	if ($kredit === null) $kredit = 0;
    	}
    	
        return $this->render('index',[
        	'model' => $model,
        	'akuns' => $akuns,
        	'dataProvider' => $dataProvider,
        	'debet' => $debet,
        	'kredit' => $kredit
        ]);
    }

    public function actionPrint($startDate, $endDate,$akun_id) {
    	$pre_query = TransaksiLain::find()
    		->andWhere(['between','tanggal',TimeHelper::getBeginningYear(TimeHelper::getTodayDate()),$startDate])
    		->andWhere(['akun_id' => $akun_id]);

    	$debit_awal = $pre_query->andWhere(['jenis_transaksi' => TransaksiLain::DEBIT])->sum('nominal');
    	$kredit_awal = $pre_query->andWhere(['jenis_transaksi' => TransaksiLain::KREDIT])->sum('nominal');

    	$data = TransaksiLain::find()->andWhere(['between','tanggal',$startDate,$endDate])->orderBy(['tanggal' => SORT_ASC])->all();


		$output = fopen('php://output', 'w');

		$total_debit = 0; $total_kredit = 0;

		fputcsv($output, ['','Saldo awal','',$debit_awal,$kredit_awal]);
		fputcsv($output, ['Tanggal', 'Deskripsi','Ref', 'Debit', 'Kredit']);

		foreach ($data as $record) {
			$recordDebit = 0;
			$recordKredit = 0;
			if($record->jenis_transaksi == "debit") {
				$recordDebit = $record->nominal;
			} else {
				$recordKredit = $record->nominal;
			}
			$total_debit += $recordDebit;
			$total_kredit += $recordKredit;

			fputcsv($output, [$record->tanggal, $record->deskripsi,$record->nomor, $recordDebit, $recordKredit]);
		}

		fputcsv($output, []);
		fputcsv($output, ['', 'Saldo Debit', '',$total_debit]);
		fputcsv($output, ['', 'Saldo Kredit', '',$total_kredit]);

		$filename = Akun::findOne($akun_id)->nama;
		header('Content-type: application/xlsx');
		header("Content-Disposition: attachment; filename=$filename.csv");
		fclose($output);

	}
    
}
