<?php
	
	use yii\helpers\ArrayHelper;
	use yii\helpers\html;
	use yii\widgets\ActiveForm;

	use app\helpers\FormatHelper;
	use app\helpers\TimeHelper;
	use app\models\db\Akun;

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

<?php if($transaksi->jenis_periode == "periode"): ?>
	<div class="row">
		<div class="col-md-3 col-md-offset-1">
			<h5>Periode</h5>
		</div>
		<div class="col-md-8">
			<h5><?= $transaksi->periode_awal . "&nbsp;&nbsp;&nbsp;&nbsp;<strong>-</strong>&nbsp;&nbsp;&nbsp;&nbsp;" . $transaksi->periode_akhir; ?></h5>
		</div>
	</div>
<?php endif; ?>

<?php if($transaksi->jenis_periode == "periode"): ?>
	<div class="row">
		<div class="col-md-3 col-md-offset-1">
			<h5>Frekuensi</h5>
		</div>
		<div class="col-md-8">
			<h5>Setiap <?php if($transaksi->frekuensi > 1) echo $transaksi->frekuensi; ?> Hari</h5>
		</div>
	</div>
<?php endif; ?>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Siaran</h5>
	</div>
	<div class="col-md-8">
		<?php if($transaksi->jenis_periode == "siaran"): ?>
			<div class="row">
				<div class="col-md-2">
					<h5><?= $transaksi->jumlah_siaran ?></h5>
				</div>
				<div class="col-md-10">
					<h5>siaran</h5>
				</div>
			</div>
		<?php endif; ?>
		<?php if($transaksi->jenis_periode == "periode"): ?>
			<div class="row">
				<div class="col-md-2">
					<h5><?= $transaksi->siaran_per_hari ?></h5>
				</div>
				<div class="col-md-10">
					<h5>siaran per hari tayang</h5>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<br>
<table class="table table-bordered">
	<tr>
		<?php if($transaksi->jenis_periode == "siaran"): ?>
			<th>Hari</th>
			<th>Tanggal</th>
		<?php endif; ?>
		<th>Jam Siaran</th>
	</tr>
	<?php foreach($siarans as $siaran): ?>
		<tr>
			<?php if($transaksi->jenis_periode == "siaran"): ?>
				<td><?= TimeHelper::getDay($siaran['tanggal'], '%Y-%m-%d') ?></td>
				<td><?= TimeHelper::getDate($siaran['tanggal'], '%Y-%m-%d') ?></td>
			<?php endif; ?>
			<td><?= $siaran['waktu'] ?></td>
		</tr>
	<?php endforeach;?>
</table>

<hr>

<table class="table table-striped">
	<tr>
		<th>Akun</th>
		<th>Jenis</th>
		<th>Nominal</th>
		<th>Terbilang</th>
		<th>Deskripsi</th>
	</tr>
	<?php foreach($listTransaksi as $data): ?>
		<tr>
			<td><?= Akun::findOne($data->akun_id)->nama ?></td>
			<td><?= $data->jenis_transaksi ?></td>
			<td><?= $data->nominal ?></td>
			<td><?= $data->terbilang ?></td>
			<td><?= $data->deskripsi ?></td>
		</tr>
	<?php endforeach; ?>
</table>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<?php $form = ActiveForm::begin([
			'fieldConfig' => [
		    	'template' => "<div class=\"row\"><div class=\"col-md-2\">{label}</div>\n<div class=\"col-md-8\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div></div>",
		    ],
		]); ?>

			<?= $form->field($confirmationForm, 'akun_id')->dropDownList(ArrayHelper::map($akun, 'id', 'nama'), ['prompt' => 'Pilih Akun']) ?>

			<?= $form->field($confirmationForm, 'jenis_transaksi')->dropDownList([ 'debit' => 'Debit', 'kredit' => 'Kredit', ], ['prompt' => 'Pilih Jenis Transaksi']) ?>

			<?= $form->field($confirmationForm, 'nominal')->textInput() ?>

			<?= $form->field($confirmationForm, 'terbilang')->textInput() ?>

			<?= $form->field($confirmationForm, 'deskripsi')->textarea(['maxlength' => 256, 'rows' => 4]) ?>

			<div class="form-group text-center">
		        <?= Html::submitButton('Tambah transaksi', ['class' => 'btn btn-warning']) ?>
		    </div>

		<?php ActiveForm::end(); ?>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<a href="<?= \Yii::$app->urlManager->createUrl(['manajerkeuangan/transaksi/newconfirm', 'id' => $transaksi->id]); ?>" class="btn btn-warning">Ulang</a>
	</div>
	<div class="col-md-6 text-right">
		<a href="<?= \Yii::$app->urlManager->createUrl(['manajerkeuangan/transaksi/doconfirm', 'id' => $transaksi->id]); ?>" class="btn btn-warning">Simpan</a>
	</div>
</div>

<br><br><br>