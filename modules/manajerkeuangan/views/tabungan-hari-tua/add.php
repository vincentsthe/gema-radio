<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\TimePickerAsset;

TimePickerAsset::register($this);

?>

<?= $this->render('_header'); ?>

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

<div class="tabungan-hari-tua-create">

    <h1>Tambah Transaksi Tabungan</h1>

    <div class="col-md-8 col-md-offset-2">
	    <div class="tabungan-hari-tua-form">

		    <?php $form = ActiveForm::begin([
				'fieldConfig' => [
			    	'template' => "<div class=\"row\"><div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div></div>",
			    ],
		    ]); ?>

		    <?= $form->field($model, 'tanggal')->textInput(['id' => 'tanggal']) ?>

		    <?= $form->field($model, 'jenis_kegiatan')->textInput(['maxlength' => 150]) ?>

		    <?= $form->field($model, 'nominal')->textInput() ?>

		    <?= $form->field($model, 'jenis_transaksi')->dropDownList([ 'debit' => 'Debit', 'kredit' => 'Kredit', ], ['prompt' => 'Pilih Jenis Transaksi']) ?>

		    <div class="form-group text-center">
		        <?= Html::submitButton('Simpan', ['class' => 'btn btn-warning']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

		</div>
	</div>

</div>

<?php
	$this->registerJS('
		$("#tanggal").datetimepicker({
			timepicker: false,
			format: "Y-m-d",
		});
	');
?>