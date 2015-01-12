<?php

namespace app\modules\manajerkeuangan\controllers;

use app\helpers\TimeHelper;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use Yii;
use app\helpers\FormatHelper;

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
    	$params = Yii::$app->request->queryParams;
		if ($params === null || !isset($params['BukuBesar'])){
			$params['BukuBesar']['tanggal_awal'] = TimeHelper::getBeginningYear(TimeHelper::getTodayDate());
			$params['BukuBesar']['tanggal_akhir'] = TimeHelper::getTodayDate();
			$params['BukuBesar']['akun_id'] = Akun::KAS; //kas;
		}
    	$debit = 0; $kredit = 0;
    	//hitung saldo dari awal banget sampe sebelum tanggal
    	if (isset($params['BukuBesar'])){
    		$debit = TransaksiLain::find()
	    		->andWhere(['<','tanggal',$params['BukuBesar']['tanggal_awal']])
				->andWhere(['>=', 'tanggal', TimeHelper::getBeginningYear($params['BukuBesar']['tanggal_awal'])])
	    		->andWhere(['jenis_transaksi'=>TransaksiLain::DEBIT])
	    		->andWhere(['akun_id'=>$params['BukuBesar']['akun_id']])
	    		->sum('nominal'); 
    		if ($debit === null) $debit = 0;
	    	$kredit = TransaksiLain::find()
	    		->andWhere(['<','tanggal',$params['BukuBesar']['tanggal_awal']])
				->andWhere(['>=', 'tanggal', TimeHelper::getBeginningYear($params['BukuBesar']['tanggal_awal'])])
	    		->andWhere(['jenis_transaksi'=>TransaksiLain::KREDIT])
	    		->andWhere(['akun_id'=>$params['BukuBesar']['akun_id']])
	    		->sum('nominal');
	    	if ($kredit === null) $kredit = 0;
    	} else {

    	}

    	$model = new BukuBesar;
		$model->tanggal_awal = TimeHelper::getBeginningYear(TimeHelper::getTodayDate());
		$model->tanggal_akhir = TimeHelper::getTodayDate();
		$model->akun_id = Akun::find()->where(['nama'=>'Kas'])->one()->id;
    	$akuns = Akun::getLeafs();
    	$dataProvider = $model->search($params);
    	

    	
 		if ($debit > $kredit) {
 			$debit -= $kredit; $kredit = 0;
 		} else {
 			$kredit -= $debit; $debit = 0;
 		}
        return $this->render('index',[
        	'model' => $model,
        	'akuns' => $akuns,
        	'dataProvider' => $dataProvider,
        	'debit' => $debit,
        	'kredit' => $kredit
        ]);
    }

    public function actionPrint($startDate, $endDate,$akun_id) {

    	$pre_query = TransaksiLain::find()
    		->andWhere(['<','tanggal',$startDate])
			->andWhere(['>=', 'tanggal', TimeHelper::getBeginningYear($startDate)])
    		->andWhere(['akun_id' => $akun_id]);

    	$debit_awal = $pre_query->andWhere(['jenis_transaksi' => TransaksiLain::DEBIT])->sum('nominal');
    	$kredit_awal = $pre_query->andWhere(['jenis_transaksi' => TransaksiLain::KREDIT])->sum('nominal');

    	$data = TransaksiLain::find()->andWhere(['>=','tanggal',$startDate])->andWhere(['<=','tanggal',$endDate])->andWhere(['akun_id' => $akun_id])->orderBy(['tanggal' => SORT_ASC])->all();


		$output = fopen('php://output', 'w');

		
		if ($debit_awal > $kredit_awal) {
			$debit_awal -= $kredit_awal; $kredit_awal = 0;
		} else {
			$kredit_awal -= $debit_awal; $debit_awal = 0;
		}
		$total_debit = $debit_awal; $total_kredit = $kredit_awal;
		fputcsv($output, ['','Saldo awal','',FormatHelper::currency($debit_awal - $kredit_awal)]);
		fputcsv($output, ['Tanggal', 'Deskripsi','Ref', 'Nominal']);

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

			fputcsv($output, [$record->tanggal, $record->deskripsi,$record->nomor,FormatHelper::currency($recordDebit - $recordKredit)]);
		}
		if ($total_debit > $total_kredit){
			$total_debit -= $total_kredit;
			$total_kredit = 0;
		} else {
			$total_kredit -= $total_debit;
			$total_debit = 0;
		}

		fputcsv($output, []);
		fputcsv($output, ['', 'Saldo Akhir', '',FormatHelper::currency($total_debit - $total_kredit)]);
		//fputcsv($output, ['', 'Saldo Kredit', '',$total_kredit]);

		$filename = Akun::findOne($akun_id)->nama;
		header('Content-type: application/xlsx');
		header("Content-Disposition: attachment; filename=$filename.csv");
		fclose($output);

	}
    
}
