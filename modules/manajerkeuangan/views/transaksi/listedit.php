<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\helpers\FormatHelper;
use yii\widgets\ActiveForm;

\app\assets\TimePickerAsset::register($this);
?>

    <h1>Edit Transaksi</h1>
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
<div class='col-xs-12'>
<?php $form = ActiveForm::begin(['method' => 'get']); ?>
<?= $form->errorSummary($model); ?>

    <div class='col-xs-4'><?= $form->field($model,'tanggal_awal')->textInput(['id'=>'tanggal_awal']); ?></div>
    <div class='col-xs-4'><?= $form->field($model,'tanggal_akhir')->textInput(['id'=>'tanggal_akhir']); ?></div>
    <div class='col-xs-4'><?= Html::submitButton('search',['class' => 'btn btn-primary']); ?></div>

<?php ActiveForm::end(); ?>
</div>
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
                return '<a class="btn btn-warning" href="' . \Yii::$app->urlManager->createUrl(['manajerkeuangan/transaksi/edit', 'id' => $model->id]) . '">Edit</a>';
            },
        ]
    ],
]); ?>
<?php
$this->registerJs(
    '   $("#tanggal_awal").datetimepicker({
            timepicker:false,
            format:"Y-m-d",
        });
        $("#tanggal_akhir").datetimepicker({
            timepicker:false,
            format:"Y-m-d",
        });
        ',\yii\web\View::POS_READY);
?>