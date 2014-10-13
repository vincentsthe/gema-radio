<?php
	
	use yii\helpers\html;
	use app\helpers\TimeHelper;

	$this->title = 'Transaksi';
?>

<br>

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

<h2 class="text-center">Bukti Pembayaran Kas</h2>

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
		<h5><?= $transaksi->nominal; ?></h5>
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
		<div class="row">
			<div class="col-md-2">
				<h5><?= $transaksi->teks_spot ?></h5>
			</div>
			<div class="col-md-10">
				<h5>teks spot</h5>
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
			<td><?= TimeHelper::getDay($siaran['tanggal'], '%Y-%m-%d') ?></td>
			<td><?= TimeHelper::getDate($siaran['tanggal'], '%Y-%m-%d') ?></td>
			<td><?= $siaran['jamMulai'] ?></td>
		</tr>
	<?php endforeach;?>
</table>

<div class="text-center">
	<button class="btn btn-success">Cetak</button>
</div>

<br><br>
<hr>

<h2 class="text-center">Bukti Pembayaran Kas</h2>

<h2 class="text-right" style="color:#555;margin-right:40px;">Arsip</h2>

<div class="row">
	<div class="col-md-12">
		<h4>No. <?= $transaksi->akun_id . "-" . TimeHelper::timeStampToFormattedDate(TimeHelper::formattedDateToTimestamp($transaksi->tanggal, '%Y-%m-%d'), 'd/m/Y') . "-" . "001"?></h4>
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
		<h5><?= $transaksi->nominal; ?></h5>
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
		<div class="row">
			<div class="col-md-2">
				<h5><?= $transaksi->teks_spot ?></h5>
			</div>
			<div class="col-md-10">
				<h5>teks spot</h5>
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
			<td><?= TimeHelper::getDay($siaran['tanggal'], '%Y-%m-%d') ?></td>
			<td><?= TimeHelper::getDate($siaran['tanggal'], '%Y-%m-%d') ?></td>
			<td><?= $siaran['jamMulai'] ?></td>
		</tr>
	<?php endforeach;?>
</table>

<br><br>
<div class="text-center">
	<button class="btn btn-success">Cetak</button>
</div>

<br><br><br>