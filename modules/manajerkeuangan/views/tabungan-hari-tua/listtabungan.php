<?php
	
	use yii\helpers\Html;
	use yii\grid\GridView;

	use app\assets\TimePickerAsset;
	use app\helpers\FormatHelper;

	TimePickerAsset::register($this);
?>

<?= $this->render('_header'); ?>

<h1>Buku Tabungan Hari Tua</h1>
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

<div class="row">
	<div class="col-md-7 col-md-offset-4">
		<form action="?" method="GET">
			<div class="row">
				<div class="col-md-1">
					<label for="tanggal1">Mulai</label>
				</div>
				<div class="col-md-4">
					<input class="form-control" id="tanggal1" type="text" name="startDate"></input>
				</div>
                <div class="col-md-1">
                    <label for="tanggal2">Akhir</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control" id="tanggal2" type="text" name="endDate"></input>
                </div>
				<div class="col-md-1">
					<button class="btn btn-warning">Proses</button>
				</div>
			</div>
		</form>
	</div>
</div>
<br><br>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'tanggal',
        'jenis_kegiatan',
        [
        	'attribute' => 'Debit',
        	'value' => function($model) {
        		if($model->jenis_transaksi == 'debit') {
        			return FormatHelper::currency($model->nominal);
        		} else {
        			return FormatHelper::currency(0);
        		}
        	},
        ],
        [
        	'attribute' => 'Kredit',
        	'value' => function($model) {
        		if($model->jenis_transaksi == 'kredit') {
        			return FormatHelper::currency($model->nominal);
        		} else {
        			return FormatHelper::currency(0);
        		}
        	},
        ],
    ],
]); ?>

<br>
<div class="row">
    <div class="col-md-2 col-md-offset-7 text-right">
        Saldo Debit
    </div>
    <div class="col-md-2 text-right">
        <strong><?= FormatHelper::currency($debit) ?></strong>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-md-offset-7 text-right">
        Saldo Kredit
    </div>
    <div class="col-md-2 text-right">
        <strong><?= FormatHelper::currency($kredit) ?></strong>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-md-offset-7 text-right">
        Saldo Total
    </div>
    <div class="col-md-2 text-right">
        <strong><?= FormatHelper::currency($debit - $kredit) ?></strong>
    </div>
</div>

<?php
	$this->registerJS('
		$("#tanggal1").datetimepicker({
			timepicker: false,
			format: "Y-m-d",
		});
        $("#tanggal2").datetimepicker({
            timepicker: false,
            format: "Y-m-d",
        });
	');
?>