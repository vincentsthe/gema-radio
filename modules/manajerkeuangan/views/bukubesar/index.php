<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    $debet = 0;
    $kredit = 0;
?>
<h2>Buku Besar</h2>
<br>
<?= $this->render('_search',['model'=>$model,'akuns' => $akuns]); ?>
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
            'value' => function($model,$key,$index,$column){
                return ($model->nominal >= 0)?$model->nominal:' ';
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Kredit',
            'value' => function($model,$key,$index,$column){
                return ($model->nominal < 0)?-$model->nominal:' ';
            }
        ]
    ],
]);
?>
<div class='col-xs-6 col-xs-offset-6'>
<table class='table table-condensed pull-right'>
    <tr><td>Saldo</td><td><?=$debet;?></td><td><?=$kredit;?></td></tr>
</table>
</div>
