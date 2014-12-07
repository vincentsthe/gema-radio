<?php
	
	use yii\helpers\Html;
	use yii\grid\GridView;

	use app\assets\TimePickerAsset;
	use app\helpers\FormatHelper;

	TimePickerAsset::register($this);
?>

<h1>Daftar Transaksi</h1>
<hr>

<div class="row">
	<div class="col-md-5 col-md-offset-6">
		<form action="?" method="GET">
			<div class="row">
				<div class="col-md-3">
					<label for="tanggal">Tanggal</label>
				</div>
				<div class="col-md-6">
					<input class="form-control" id="tanggal" type="text" name="date"></input>
				</div>
				<div class="col-md-3">
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
        [
        	'attribute' => 'Akun',
        	'value' => function($model) {
        		return $model->akun->nama;
        	},
        ],
        'kegiatan',
        [
        	'attribute' => 'Debit',
        	'value' => function($model) {
        		if($model->jenis_transaksi == 'debit') {
        			return '<span class="green">' . FormatHelper::currency($model->nominal) . '</span>';
        		} else {
        			return '<span class="green">' . FormatHelper::currency(0) . '</span>';
        		}
        	},
			'format' => 'html',
        ],
        [
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
        [
        	'attribute' => 'Ubah',
        	'format' => 'raw',
        	'value' => function($model) {
        		return '<a class="btn btn-warning" href="' . \Yii::$app->urlManager->createUrl(['manajerkeuangan/transaksi/update', 'id' => $model->id]) . '">Ubah</a>';
        	},
        ]
    ],
]); ?>

<?php
	$this->registerJS('
		$("#tanggal").datetimepicker({
			timepicker: false,
			format: "Y-m-d",
		});
	');
?>