<?php
    use app\helpers\FormatHelper;
    use yii\bootstrap\Nav;
    use yii\grid\GridView;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use app\models\db\Akun;

?>
<h2>Laporan Keuangan</h2>
<?= Nav::widget([
        'options' => ['class' => 'nav nav-tabs'],
        'items' => [
            ['label' => 'Neraca', 'url' => ['index','jenis'=>'neraca']],
            ['label' => 'Laba Rugi', 'url' => ['index','jenis'=>'laba_rugi']],
        ],
    ]);
?>
<br>
<?php Pjax::begin(); ?>
<?=$this->render('_search',['model'=>$searchModel,'jenis'=>$jenis]); ?>
<?php //Html::a('Update laporan','update',['class'=>'btn btn-warning']); ?><br><br><br>

<div class="col-xs-8">
<table class="table table-striped table-condensed">
    <tr><th>Keterangan</th><th>Nominal</th></tr>
    <?php foreach($rootAkuns as $rootakun) printRecursive($rootakun,0,$searchModel); ?>


    <?php
        $rugi_laba = 0;
        $aktiva = 0;
        $pasiva = 0;
        $modal = 0;

        foreach($rootAkuns as $rootakun) {
            $current_value = Akun::nilaiLaporan($rootakun->id,getTotalDebit($rootakun));
            

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
            $kredit = $total;
        }*/

        $pasiva_seimbang = $pasiva + $modal + $rugi_laba;
    ?>
    <tr>
        <td><b>Rugi Laba Tahun Berjalan</b></td>
        <td><span class='pull-right <?=($rugi_laba >= 0)?'green':'red';?>'><?=FormatHelper::currency($rugi_laba);?></span></td>
    </tr>
    <?php if ($jenis == 'neraca'): ?>
    <tr>
        <td><b>Total Pasiva</b></td>
        <td><span class='pull-right green'><?=FormatHelper::currency($pasiva_seimbang);?></span></td>
    </tr>
    <?php endif; ?>
</table>
    <!-- <div class="row">
        <div class="col-md-3 col-md-offset-6">
            <h4>Total</h4>
        </div>
        <div class="col-md-3">
            <h4 class="green"><strong><= FormatHelper::currency($debit) ?></strong></h4>
            <h4 class="red"><strong><= FormatHelper::currency($kredit) ?></strong></h4>
        </div>
        <br><br>
    </div> -->
    <?= Html::a('Export ke CSV',['print','jenis'=>$jenis,'tanggal_awal'=>$searchModel->tanggal_awal,'tanggal_akhir'=>$searchModel->tanggal_akhir],['class'=>'btn btn-primary','target'=>'_blank','data-pjax'=>'0']); ?>
</div>
<?php Pjax::end(); ?>
<?php
    /**
     * @param Akun $model
     */
    function printRecursive($model,$depth,&$searchModel){
        $childs = $model->getChilds()->all();
        $debit = null; $kredit = null;

        if (count($childs) > 0){
            echo "<tr><td>".spaces($depth)."$model->nama</td><td></td><td></td></tr>";

            foreach($childs as $child){
                printRecursive($child,$depth+1,$searchModel);
            }
            $model->updateHarga($searchModel->tanggal_awal,$searchModel->tanggal_akhir);
            
            $color = (Akun::nilaiLaporan($model->id,$model->harga) >= 0)?'green':'red';
            //khusus pasiva ditaruh belakang biar seimbang
            if ($model->id != Akun::PASIVA)
                echo "<tr><td>".spaces($depth)."<strong>Total $model->nama</td><td><span class='pull-right $color'>".FormatHelper::currency(Akun::nilaiLaporan($model->id,$model->harga))."</span></strong></td></tr>";
        } else {
            $model->updateHarga($searchModel->tanggal_awal,$searchModel->tanggal_akhir);
            $color = (Akun::nilaiLaporan($model->id,$model->harga) >= 0)?'green':'red';
            echo "<tr><td>".spaces($depth)."$model->nama</td><td><span class='pull-right $color'>".FormatHelper::currency(Akun::nilaiLaporan($model->id,$model->harga))."</span></td></tr>";   
        }
    }

    function getTotalDebit($model) {
        $childs = $model->getChilds()->all();

        if (count($childs) > 0){
            $total = 0;

            foreach($childs as $child){
                $total += getTotalDebit($child);
            }

            return $total;
        } else {
            return $model->harga;
        }
    }

    function spaces($depth){
        $result = '';
        while ($depth > 0){ $depth--; $result.='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'; }
        return $result;
    }
?>
