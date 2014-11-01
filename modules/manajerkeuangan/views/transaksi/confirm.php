<?php
	
	use yii\helpers\ArrayHelper;
	use yii\helpers\html;
	use yii\widgets\ActiveForm;

	use app\helpers\FormatHelper;
	use app\helpers\TimeHelper;

	$this->title = 'Transaksi';
?>

<br>
<h2 class="text-center">Transaksi</h2>

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

<div class="row">
	<div class="col-md-12">
		<h4>No. <?= $transaksi->akun_id . "-" . TimeHelper::timeStampToFormattedDate(TimeHelper::formattedDateToTimestamp($transaksi->tanggal, '%Y-%m-%d'), 'd/m/Y') . "-" . $transaksi->id ?></h4>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Dibayarkan Kepada</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $transaksi->nama; ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Uang Sebanyak</h5>
	</div>
	<div class="col-md-8">
		<h5><?= FormatHelper::currency($transaksi->nominal); ?></h5>
	</div>
</div>


<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Terbilang</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $transaksi->terbilang; ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Periode</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $transaksi->periode_awal . "&nbsp;&nbsp;&nbsp;&nbsp;<strong>-</strong>&nbsp;&nbsp;&nbsp;&nbsp;" . $transaksi->periode_akhir; ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Jenis Penyiaran</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $transaksi->jenis_transaksi; ?></h5>
	</div>
</div>

<?php if($transaksi->jenis_transaksi == 'Iklan nasional'): ?>
	<div class="row">
		<div class="col-md-3 col-md-offset-1">
			<h5>Order No</h5>
		</div>
		<div class="col-md-8">
			<h5><?= $transaksi->no_order; ?></h5>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Siaran</h5>
	</div>
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-2">
				<h5><?= $transaksi->jumlah_siaran ?></h5>
			</div>
			<div class="col-md-10">
				<h5>siaran</h5>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2">
				<h5><?= $transaksi->siaran_per_hari ?></h5>
			</div>
			<div class="col-md-10">
				<h5>kali/hari</h5>
			</div>
		</div>
	</div>
</div>

<br>
<table class="table table-bordered">
	<tr>
		<th>Hari</th>
		<th>Tanggal</th>
		<th>Jam Siaran</th>
	</tr>
	<?php foreach($siarans as $siaran): ?>
		<tr>
			<td><?= TimeHelper::getDay($siaran->tanggal, '%Y-%m-%d') ?></td>
			<td><?= TimeHelper::getDate($siaran->tanggal, '%Y-%m-%d') ?></td>
			<td><?= $siaran->waktu_mulai ?></td>
		</tr>
	<?php endforeach;?>
</table>

<hr>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<?php $form = ActiveForm::begin([
			'fieldConfig' => [
		    	'template' => "<div class=\"row\"><div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div></div>",
		    ],
		]); ?>

			<?= $form->field($confirmationForm, 'akun_id')->dropDownList(ArrayHelper::map($akun, 'id', 'nama'), ['prompt' => 'Pilih Akun']) ?>

			<?= $form->field($confirmationForm, 'jenis_transaksi')->dropDownList([ 'debit' => 'Debit', 'kredit' => 'Kredit', ], ['prompt' => 'Pilih Jenis Transaksi']) ?>

			<div class="form-group text-center">
		        <?= Html::submitButton('Konfirmasi', ['class' => 'btn btn-warning']) ?>
		    </div>

		<?php ActiveForm::end(); ?>
	</div>
</div>

<br><br><br>