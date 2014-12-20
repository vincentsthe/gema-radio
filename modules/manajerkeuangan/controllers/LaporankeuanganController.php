<?php

namespace app\modules\manajerkeuangan\controllers;

use app\helpers\TimeHelper;
use yii\web\Controller;
use app\models\db\Akun;
use app\modules\manajerkeuangan\models\form\LaporanKeuanganForm;
use app\helpers\FormatHelper;

class LaporankeuanganController extends BaseController
{
    public function actionIndex($jenis = 'neraca')
    {
        $searchModel = new LaporanKeuanganForm;
        $searchModel->tanggal_awal = TimeHelper::getBeginningYear(TimeHelper::getTodayDate());
        $searchModel->tanggal_akhir = TimeHelper::getTodayDate();
        if ($searchModel->load(\Yii::$app->request->get()) && $searchModel->validate()) {
        }

        if ($jenis == 'neraca'){
            $rootAkuns = Akun::findNeraca()->all();
        } else {
            $rootAkuns = Akun::findLabaRugi()->andWhere(['parent' => 0])->all();
        }

        foreach($rootAkuns as $rootAkun) {
            $rootAkun->updateHarga($searchModel->tanggal_awal,$searchModel->tanggal_akhir);
        }
        return $this->render('index',[
         	'rootAkuns' => $rootAkuns,
             'searchModel' => $searchModel,
             'jenis' => $jenis
         ]);
    }

    public function actionUpdate()
    {
    	Akun::updateAllHarga();
    	return $this->redirect('index');
    }

    public function actionPrint($jenis,$tanggal_awal,$tanggal_akhir) {
        if ($jenis == 'neraca'){
            $rootAkuns = Akun::findNeraca()->all();
        } else {
            $rootAkuns = Akun::findLabaRugi()->andWhere(['parent' => 0])->all();
        }
        $output = fopen('php://output','w');

        fputcsv($output,['Keterangan','debit','kredit']);
        foreach($rootAkuns as $rootAkun)
            $this->printCSVRecursive($output,$rootAkun,0,$tanggal_awal,$tanggal_akhir);

        header('Content-type: application/xlsx');
        header('Content-Disposition: attachment; filename=tes.csv');
    }

    private function printCSVRecursive($output,$model,$depth,$tanggal_awal,$tanggal_akhir){
        $childs = $model->getChilds()->all();
        $debit = null; $kredit = null;

        if (count($childs) > 0){
            fputcsv($output, [$model->nama,'','']);
            foreach($childs as $child){
                $this->printCSVRecursive($output,$child,$depth+1,$tanggal_awal,$tanggal_akhir);
            }
            $model->updateHarga($tanggal_awal,$tanggal_akhir);
            
            if ($model->harga > 0){ $debit = $model->harga; } else { $kredit = -$model->harga; }
            fputcsv($output, ["Total $model->nama",FormatHelper::currency($debit),FormatHelper::currency($kredit)]);           
        } else {
            $model->updateHarga($tanggal_awal,$tanggal_akhir);

            if ($model->harga > 0){ $debit = $model->harga; } else { $kredit = -$model->harga; }
            fputcsv($output, [$model->nama,FormatHelper::currency($debit),FormatHelper::currency($kredit)]); 
        }
    }

}
