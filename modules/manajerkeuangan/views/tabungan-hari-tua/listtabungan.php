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
					<input class="form-control" id="tanggal1" type="text" name="startDate" value='<?=$startDate;?>'></input>
				</div>
                <div class="col-md-1">
                    <label for="tanggal2">Akhir</label>
                </div>
                <div class="col-md-4">
                    <input class="form-control" id="tanggal2" type="text" name="endDate" value='<?=$endDate;?>'></input>
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
            'label' => 'Debit',
        	'value' => function($model) {
        		if($model->jenis_transaksi == 'debit') {
        			return "<span class='green'>" . FormatHelper::currency($model->nominal) . "</span>";
        		} else {
        			return "<span class='green'>" . FormatHelper::currency(0) . "</span>";
        		}
        	},
            'format' => 'html',
        ],
        [
            'class' => 'yii\grid\DataColumn',
        	'attribute' => 'Kredit',
        	'value' => function($model) {
        		if($model->jenis_transaksi == 'kredit') {
        			return '<span class="red">' . FormatHelper::currency($model->nominal) . '</span>';
        		} else {
        			return '<span class="red">' . FormatHelper::currency(0) . '</span>';
        		}
        	},
            'format' => 'html',
        ],
    ],
]); ?>

<br>
<div class="row">
    <div class="col-md-2">
        <a class="btn btn-warning" target="_blank" href="<?= Yii::$app->UrlManager->createUrl(['manajerkeuangan/tabungan-hari-tua/printtabungan', 'startDate' => $startDate, 'endDate' => $endDate]) ?>">Print</a>
    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-3 col-md-offset-6 text-right">
                Saldo Debit
            </div>
            <div class="col-md-2 text-right green">
                <strong><?= FormatHelper::currency($debit) ?></strong>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-md-offset-6 text-right">
                Saldo Kredit
            </div>
            <div class="col-md-2 text-right red">
                <strong><?= FormatHelper::currency($kredit) ?></strong>
            </div>
        </div>
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