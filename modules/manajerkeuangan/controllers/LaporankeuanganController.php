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

        fputcsv($output,['Keterangan','nominal']);
        foreach($rootAkuns as $rootAkun)
            $this->printCSVRecursive($output,$rootAkun,0,$tanggal_awal,$tanggal_akhir);
        
        //rugi laba
        $rugi_laba = 0;
        $aktiva = 0;
        $pasiva = 0;
        $modal = 0;
        foreach($rootAkuns as $rootakun) {
            $current_value = Akun::nilaiLaporan($rootakun->id,$this->getTotal($rootakun));
            if ($rootakun->id == Akun::AKTIVA){
                $rugi_laba += $current_value;
                $aktiva = $current_value;
            } else  if ($rootakun->id == Akun::PASIVA){
                $rugi_laba -= $current_value;
                $pasiva = $current_value;
            } else if($rootakun->id == Akun::MODAL){
                $rugi_laba -= $current_value;
                $modal = $current_value;
            } else { //BIAYA PENDAPATAN 
                $rugi_laba += $current_value;
            }
        }
        /*
        if($total > 0) {
            $kredit = 0;
            $debit = $total;
        } else {
            $debit = 0;
            $kredit = -$total;
        }*/

        fputcsv($output,['Rugi laba tahun berjalan',FormatHelper::currency($rugi_laba)]);
        if ($jenis == 'neraca'){
            fputcsv($output,['Total Pasiva',FormatHelper::currency($pasiva + $modal + $rugi_laba)]);
        }
        //end of rugi laba tahun berjalan
        $nama_file = ($jenis == 'neraca')?'neraca':'labarugi';
        header('Content-type: application/xlsx');
        header('Content-Disposition: attachment; filename='.$nama_file.'.csv');
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
            
            //if ($model->harga > 0){ $debit = $model->harga; } else { $kredit = -$model->harga; }
            fputcsv($output, ["Total $model->nama",FormatHelper::currency(Akun::nilaiLaporan($model->id,$model->harga))]);           
        } else {
            $model->updateHarga($tanggal_awal,$tanggal_akhir);

            //if ($model->harga > 0){ $debit = $model->harga; } else { $kredit = -$model->harga; }
            //pasiva tidak perlu ditulis
            if ($model->id != Akun::PASIVA)
                fputcsv($output, [$model->nama,FormatHelper::currency(Akun::nilaiLaporan($model->id,$model->harga))]); 
        }
    }

    private function getTotal($model) {
        $childs = $model->getChilds()->all();

        if (count($childs) > 0){
            $total = 0;

            foreach($childs as $child){
                $total += $this->getTotal($child);
            }

            return $total;
        } else {
            return $model->harga;
        }
    }

    private function printSpaces($n){
        $ret = '';
        for($i = 0; $i < $n; ++$i){
            $ret .= ' ';
        }
        return $ret;
    }
}
