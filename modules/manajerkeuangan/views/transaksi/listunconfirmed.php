<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\helpers\FormatHelper;

?>

<h1>Konfirmasi Transaksi</h1>
<hr>

<?php if(Yii::$app->session->hasFlash('success')): ?>
	<div class="alert alert-success">
		<?= Yii::$app->session->getFlash('success'); ?>
	</div>
<?php endif; ?>
<?php if(Yii::$app->session->hasFlash('error')): ?>
	<div class="alert alert-danger">
		<?= Yii::$app->session->getFlash('error'); ?>
	</div>
<?php endif; ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama',
            'tanggal',
            [
                'attribute' => 'Nominal',
                'format' => 'raw',
                'value' => function($model) {
                    return FormatHelper::currency($model->nominal);
                },
            ],
            'terbilang',
            'jenis_transaksi',

            [
            	'attribute' => 'Konfirmasi',
            	'format' => 'raw',
            	'value' => function($model) {
            		return '<a class="btn btn-warning" href="' . \Yii::$app->urlManager->createUrl(['manajerkeuangan/transaksi/confirm', 'id' => $model->id]) . '">Konfirmasi</a>';
            	},
            ]
        ],
    ]); ?>