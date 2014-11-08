<?php
	
	use yii\helpers\html;

	use app\helpers\TimeHelper;
	use app\helpers\FormatHelper;

	$this->title = 'Transaksi';
?>

<br>
<h2 class="text-center">Bukti Pembayaran Kas</h2>

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
			<td><?= $siaran['jam'] ?></td>
		</tr>
	<?php endforeach;?>
</table>

<br><br>
<hr>

<br><br>
<div class="text-center">
	<?php if($transaksi->jenis_periode == "siaran"): ?>
	<a href="<?= \Yii::$app->urlManager->createUrl(['petugas/transaksi/createtransaksisiaran']); ?>" class="btn btn-success">Kembali</a>
	<?php endif; ?>
	<a href="<?= \Yii::$app->urlManager->createUrl(['petugas/transaksi/save']); ?>" class="btn btn-success">Simpan</a>
</div>

<br><br><br>