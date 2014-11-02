<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\TimePickerAsset;
use app\assets\CreateTransaksiAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Form\TransaksiForm */

$this->title = 'Create Transaksi';
$this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

TimePickerAsset::register($this);
CreateTransaksiAsset::register($this);

?>
<div class="transaksi-create">

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

	    <?= $form->field($model, 'jumlah_siaran', ['template'=>"<div class=\"row\"><div class=\"col-md-2\"><strong>Jumlah</strong></div><div class=\"col-md-2\">{input}</div><div class=\"col-md-8\" style=\"position:relative;top:5px;\"><strong>Siaran</strong></div><div class=\"col-md-offset-2 col-md-10\">{error}</div></div>"])->textInput(['id'=>'jumlahSiaran']) ?>

	    <?= $form->field($model, 'siaran_per_hari', ['template'=>"<div class=\"row\"><div class=\"col-md-2 col-md-offset-2\">{input}</div><div class=\"col-md-8\" style=\"position:relative;top:5px;\">{label}</div><div class=\"col-md-offset-2 col-md-10\">{error}</div></div>"])->textInput(['id'=>'siaranPerHari']) ?>

	    <div class="plain-box">
	    	<ul class="nav nav-tabs" role="tablist" id="tab">
			</ul>
			<br>
			<div class="row">
				<div class="col-md-2">
					<strong>Tanggal</strong>
				</div>
				<div class="col-md-4">
					<input id="tanggalSiaran"type="text" class="form-control">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-2">
					<strong>Jam Mulai</strong>
				</div>
				<div class="col-md-4">
					<input id="jamMulaiSiaran" type="text" class="form-control">
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-2">
					<strong>Jam Selesai</strong>
				</div>
				<div class="col-md-4">
					<input id="jamSelesaiSiaran" type="text" class="form-control">
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