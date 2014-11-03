<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use app\helpers\FormatHelper;
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
        'jenis_transaksi',
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Debet',
            'value' => function($model,$key,$index,$column) use(&$debet){
                $value = ($model->nominal >= 0)?$model->nominal:' ';
                $debet += $value;
                return "<span class='pull-right'>".FormatHelper::currency($value)."</span>";
            },
            'format' => 'html',
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Kredit',
            'value' => function($model,$key,$index,$column) use(&$kredit){
                $value =  ($model->nominal < 0)?-$model->nominal:' ';
                $kredit += $value;
                return "<span class='pull-right'>".FormatHelper::currency($value)."</span>";
            },
            'format' => 'html',
        ]
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
