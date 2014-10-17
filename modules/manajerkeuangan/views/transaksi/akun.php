<?php
	use yii\helpers\Html;
	use yii\helpers\ArrayHelper;
	use yii\widgets\ActiveForm;
?>

<h1>Daftar Akun</h1>
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

<div style="height:350px;overflow:auto;border: 1px solid #EEE;">
	<table class="table table-striped">
		<tr>
			<th>Kode Akun</th>
			<th>Akun</th>
		</tr>
		<?php foreach($akun as $record): ?>
			<tr>
				<td><?= $record->kode; ?></td>
				<td><?= $record->nama; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<hr>

<div class="col-md-10 col-md-offset-1">
	<div class="text-center"><h2>Tambah Akun</h2></div>
	<br>

	<?php $form = ActiveForm::begin([
		'fieldConfig' => [
	    	'template' => "<div class=\"row\"><div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div></div>",
	    ],
    ]); ?>

	    <?= $form->field($model, 'nama')->textInput(['maxlength' => 150]) ?>

	    <?= $form->field($model, 'parent')->dropDownList([
	    	'5' => 'Aktiva Lancar',
	    	'10' => 'Aktiva Tetap Hibah',
	    	'16' => 'Aktiva Tetap Pembelian',
	    	'22' => 'Akumulasi Penyusutan Aktiva Tetap',
	    	'29' => 'Pasiva Lancar',
	    	'37' => 'Modal',
	    	'41' => 'Pendapatan Usaha',
	    	'47' => 'Biaya Usaha',
	    	'54' => 'Pendapatan di Luar Usaha',
	    	'58' => 'Biaya di Luar Usaha',
	    ], ['prompt' => 'Pilih Klasifikasi Akun']) ?>

	    <?= $form->field($model, 'kode')->textInput() ?>

	    <div class="form-group text-center">
	        <?= Html::submitButton('Buat Akun', ['class' => 'btn btn-warning']) ?>
	    </div>

    <?php ActiveForm::end(); ?>

</div>