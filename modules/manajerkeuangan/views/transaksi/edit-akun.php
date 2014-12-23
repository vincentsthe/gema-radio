<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	?>
<h1>Edit akun</h1>
<?php $form = ActiveForm::begin(); ?>
	<?= $form->errorSummary($model); ?>
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
	        <?= Html::submitButton('Ubah Akun', ['class' => 'btn btn-warning']) ?>
	    </div>

    <?php ActiveForm::end(); ?>