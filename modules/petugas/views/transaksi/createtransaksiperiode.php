<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\TimePickerAsset;
use app\assets\CreateTransaksiPeriodeAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Form\TransaksiForm */

TimePickerAsset::register($this);
CreateTransaksiPeriodeAsset::register($this);

?>
<div class="transaksi-create">

	<?=
		$this->render('_tabs');
	?>
    <h1>Transaksi</h1>

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

    <div class="transaksi-form">

	    <?php $form = ActiveForm::begin([
	    	'id' => 'form',
	    	'enableAjaxValidation' => false,
	    	'fieldConfig' => [
	        	'template' => "<div class=\"row\"><div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div></div>",
	        	],
	        ]); ?>

	    <?= $form->field($model, 'nama')->textInput(['maxlength' => 100]) ?>

	    <?= $form->field($model, 'tanggal')->textInput(['id'=>'tanggal']) ?>

	    <?= $form->field($model, 'jenis_transaksi')->dropDownList([ 'Berita Kehilangan' => 'Berita Kehilangan', 'Iklan nasional' => 'Iklan nasional', 'Iklan lokal' => 'Iklan lokal', 'Rekaman' => 'Rekaman', 'Pengumuman' => 'Pengumuman', ], ['prompt' => '', 'id'=>'jenisTransaksi']) ?>

	    <?= $form->field($model, 'no_order')->textInput(['id'=>'noOrder']) ?>

	    <?= $form->field($model, 'nominal')->textInput() ?>

	    <?= $form->field($model, 'terbilang')->textInput(['maxlength' => 300]) ?>

	    <div class="row">
	    	<div class="col-md-2">
	    		<h4><span style="font-weight:bold;font-size:14px;margin-bottom:5px;">Periode</span></h4>
	    	</div>
	    	<div class="col-md-3">
	    		<?= $form->field($model, 'periode_awal', ['template'=>"<div class=\"row\"><div class=\"col-md-12\">{input}</div><div class=\"col-md-12\">{error}</div></div>"])->textInput(['id' => 'tanggalAwal']) ?>
	    	</div>
	    	<div class="col-md-3">
	    		<?= $form->field($model, 'periode_akhir', ['template'=>"<div class=\"row\"><div class=\"col-md-12\">{input}</div><div class=\"col-md-12\">{error}</div></div>"])->textInput(['id' => 'tanggalAkhir']) ?>
	    	</div>
	    </div>

	    <?= Html::hiddenInput('TransaksiPeriodeForm[jenis_periode]', 'periode') ?>

	     <?= $form->field($model, 'frekuensi')->radioList(['1' => 'Setiap Hari ', '2' => 'Setiap 2 Hari ', '3' => 'Setiap 3 Hari '], ['id' => 'frekuensi']) ?>

	    <?= $form->field($model, 'siaran_per_hari', ['template'=>"<div class=\"row\"><div class=\"col-md-2\"><strong>Jumlah</strong></div><div class=\"col-md-2\">{input}</div><div class=\"col-md-8\" style=\"position:relative;top:5px;\"><strong>Siaran Per Hari Tayang</strong></div><div class=\"col-md-offset-2 col-md-10\">{error}</div></div>"])->textInput(['id'=>'siaranPerHari']) ?>

	    <div class="plain-box">
	    	<ul class="nav nav-tabs" role="tablist" id="tab">
			</ul>
			<br>
			<div class="row">
				<div class="col-md-2">
					<strong>Jam Mulai</strong>
				</div>
				<div class="col-md-4">
					<input id="jamSiaran" type="text" class="form-control">
				</div>
			</div>
	    </div>
	    <div id="input"></div>

	    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 10]) ?>

	    <div class="form-group row">
	        <button id="button" type="button" class="btn btn-success col-md-offset-3">Buat</button>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>