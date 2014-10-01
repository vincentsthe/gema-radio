<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\TimePickerAsset;

/* @var $this yii\web\View */
/* @var $model app\models\db\Transaksi */

$this->title = 'Create Transaksi';
$this->params['breadcrumbs'][] = ['label' => 'Transaksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

TimePickerAsset::register($this);
?>
<div class="transaksi-create">

    <h1>Transaksi</h1>

    <div class="transaksi-form">

	    <?php $form = ActiveForm::begin([
	    ]); ?>

	    <?= $form->field($model, 'nama')->textInput(['maxlength' => 100]) ?>

	    <?= $form->field($model, 'tanggal')->textInput(['id'=>'tanggal']) ?>

	    <?= $form->field($model, 'no_order')->textInput() ?>

	    <?= $form->field($model, 'produk')->textInput(['maxlength' => 100]) ?>

	    <?= $form->field($model, 'nominal')->textInput() ?>

	    <?= $form->field($model, 'terbilang')->textInput(['maxlength' => 300]) ?>

	    <?= $form->field($model, 'jumlah_siaran')->textInput() ?>

	    <?= $form->field($model, 'siaran_per_hari')->textInput() ?>

	    <?= $form->field($model, 'teks_spot')->textInput() ?>

	    <?= $form->field($model, 'deskripsi')->textarea(['rows' => 6]) ?>

	    <?= $form->field($model, 'jenis_transaksi')->dropDownList([ 'Berita Kehilangan' => 'Berita Kehilangan', 'Iklan nasional' => 'Iklan nasional', 'Iklan lokal' => 'Iklan lokal', 'Rekaman' => 'Rekaman', 'Pengumuman' => 'Pengumuman', ], ['prompt' => '']) ?>

	    <?= $form->field($model, 'akun_id')->textInput() ?>

	    <div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>


</div>
<?php
	$this->registerJs('$("#tanggal").datetimepicker({
		timepicker:false,
		format:"Y-m-d",
	});');
?>
