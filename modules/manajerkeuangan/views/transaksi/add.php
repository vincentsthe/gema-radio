<?php
	use yii\helpers\Html;
	use yii\helpers\ArrayHelper;
	use yii\widgets\ActiveForm;

	use app\assets\TimePickerAsset;

	TimePickerAsset::register($this);
?>

<?= $this->render('_header'); ?>

<h1>Tambah Transaksi</h1>

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
	
<div class="transaksi-lain-form">

    <?php $form = ActiveForm::begin([
		'fieldConfig' => [
	    	'template' => "<div class=\"row\"><div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div></div>",
	    ],
    ]); ?>

    <?= $form->field($model, 'kegiatan')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'akun_id')->dropDownList(ArrayHelper::map($akun, 'id', 'nama'), ['prompt' => 'Pilih Akun']) ?>

    <?= $form->field($model, 'jenis_transaksi')->dropDownList([ 'debit' => 'Debit', 'kredit' => 'Kredit', ], ['prompt' => 'Pilih Jenis Transaksi']) ?>

    <?= $form->field($model, 'tanggal')->textInput(['id' => 'tanggal']) ?>

    <?= $form->field($model, 'nominal')->textInput() ?>

    <?= $form->field($model, 'terbilang')->textInput(['maxlength' => 300]) ?>

    <div class="form-group text-center">
        <?= Html::submitButton('Cetak', ['class' => 'btn btn-warning']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
	$this->registerJS('
		$("#tanggal").datetimepicker({
			timepicker: false,
			format: "Y-m-d",
		});
	');
?>