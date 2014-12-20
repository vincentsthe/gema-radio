<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use app\helpers\FormatHelper;
?>

<?php
    $debit = 0;
    $kredit = 0;
?>
<h2>Buku Besar</h2>
<br>
<?= $this->render('_search',['model'=>$model,'akuns' => $akuns]); ?><br>
<div class='col-xs-6 col-xs-offset-6'>
<table class='table table-condensed pull-right'>
    <tr><td>Keadaan awal: (<?=$model->tanggal_awal?>) </td><td><?=FormatHelper::currency($debet);?></td><td><?=FormatHelper::currency($kredit);?></td></tr>
</table>
</div>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        'tanggal',
        'deskripsi',
        [
            'label' => 'Ref',
            'value' => function($model) {
                return $model->nomor;
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Debet',
            'value' => function($model,$key,$index,$column) use(&$debet, $kredit){
                if($model->jenis_transaksi == "debit") {
                    $debet += $model->nominal;
                    $value = $model->nominal;
                } else {
                    $kredit += $model->nominal;
                    $value = 0;
                }
                return "<span class='pull-right green'>" . FormatHelper::currency($value) . "</span>";
            },
            'format' => 'html',
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Nominal',
            'value' => function($model,$key,$index,$column) use(&$debet, $kredit){
                if($model->jenis_transaksi == "debit") {
                    $debet += $model->nominal;
                    $value = 0;
                } else {
                    $kredit += $model->nominal;
                    $value = -$model->nominal;
                }
                return "<span class='pull-right red'>" . FormatHelper::currency($value) . "</span>";
            },
            'format' => 'html',
        ],
    ],
]);
?>
<?php
    if ($debet > $kredit) {$debet -= $kredit; $kredit = 0; } else {$kredit -= $debet; $debet = 0;}
?>
<div class='col-xs-6 col-xs-offset-6'>
<table class='table table-condensed pull-right'>
    <tr><td>Saldo Akhir (<?=$model->tanggal_akhir?>)</td><td class="green"><?=FormatHelper::currency($debet);?></td><td class="red"><?=FormatHelper::currency($kredit);?></td></tr>
</table>
</div>
<?= "Dari tanggal $model->tanggal_awal hingga $model->tanggal_akhir : <br/>"; ?>
<?= Html::a('Export to CSV',['print','startDate' => $model->tanggal_awal,'endDate'=> $model->tanggal_akhir,'akun_id' => $model->akun_id],['class'=>'btn btn-primary','target'=>'_blank']); ?>
&nbsp;<?= Html::a('',['print-all','startDate' => $model->tanggal_awal,'endDate'=> $model->tanggal_akhir],['id'=>'print-all','class'=>'btn btn-primary','onclick'=>'return click_all()','style'=>'display:none']); ?>
<?php foreach($akuns as $akun) {
    echo Html::a('',['print','startDate' => $model->tanggal_awal,'endDate'=>$model->tanggal_akhir,'akun_id' => $akun->id],['class'=>'print-clicker']);
}
?>
<?php $this->registerJs("
function click_all(){
    $('.print-clicker').each(function(index){
        var href = $(this).attr(href);
        window.location.href = href;
    });
    console.log('woi');
    return false;
};",\yii\web\View::POS_HEAD);
?>