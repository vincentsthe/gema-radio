<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
?>
<h2>Buku Besar</h2>
<br>
<?= $this->render('_search',['model'=>$model,'akuns' => $akuns]); ?>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
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
