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
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Nominal',
            'value' => function($model,$key,$index,$column) use(&$debet, $kredit){
                if($model->jenis_transaksi == "debit") {
                    $debet += $model->nominal;
                    $value = $model->nominal;
                } else {
                    $kredit += $model->nominal;
                    $value = -$model->nominal;
                }
                return "<span class='pull-right'>".FormatHelper::currency($value)."</span>";
            },
            'format' => 'html',
        ],
        'deskripsi',
    ],
]);
?>
<?php
    if ($debet > $kredit) {$debet -= $kredit; $kredit = 0; } else {$kredit -= $debet; $debet = 0;}
?>
<div class='col-xs-6 col-xs-offset-6'>
<table class='table table-condensed pull-right'>
    <tr><td>Saldo Akhir (<?=$model->tanggal_akhir?>)</td><td><?=FormatHelper::currency($debet);?></td><td><?=FormatHelper::currency($kredit);?></td></tr>
</table>
</div>
