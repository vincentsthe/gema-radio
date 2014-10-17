<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\helpers\TimeHelper;
use app\assets\PrintAsset;

PrintAsset::register($this);

?>

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

<div id="arsip">
<h2 class="text-center">Bukti Pembayaran Kas</h2>
<h2 class="text-right" style="color:#555;margin-right:40px;">Arsip</h2>
<br><br>

<div class="row">
	<div class="col-md-12">
		<h4>No. <?= $model->akun->kode . "-" . TimeHelper::timeStampToFormattedDate(TimeHelper::formattedDateToTimestamp($model->tanggal, '%Y-%m-%d'), 'd/m/Y') . "-" . $model->id?></h4>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Kegiatan</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $model->kegiatan; ?></h5>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Uang Sebanyak</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $model->nominal; ?></h5>
	</div>
</div>


<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h5>Terbilang</h5>
	</div>
	<div class="col-md-8">
		<h5><?= $model->terbilang; ?></h5>
	</div>
</div>



</div>

<br><br>
<div class="text-center">
	<button id="arsipButton" class="btn btn-warning">Cetak</button>
	<a class="btn btn-warning" href="<?= Yii::$app->urlManager->createUrl(['/manajerkeuangan/transaksi/add']); ?>">Kembali</a>
</div>

<br><br><br>

<?php
	$this->registerJs('

		$("#arsipButton").click(function() {
			html2canvas($("#arsip"), {
				onrendered: function(canvas) {
					var doc = new jsPDF();
					var context = canvas.getContext("2d");
					var newCanvas = document.createElement("canvas");
					newCanvas.width = 900;
					newCanvas.height = 3000;
					var newContext = newCanvas.getContext("2d");
					newContext.scale(.7, .7);
					newContext.drawImage(canvas, 130, 130);
					var canvasData = newCanvas.toDataURL("images/jpeg");
					doc.addImage(canvasData, "JPEG", 0, 0);
					doc.save("test.pdf");
				}
			});
		});
	');
?>