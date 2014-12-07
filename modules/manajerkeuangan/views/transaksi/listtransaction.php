<?php
	
	use yii\helpers\Html;
	use yii\helpers\ArrayHelper;
	use yii\grid\GridView;
	use yii\widgets\ActiveForm;

	use app\assets\TimePickerAsset;
	use app\helpers\FormatHelper;

	TimePickerAsset::register($this);
?>

<h1>Daftar Transaksi</h1>
<hr>

<div class='col-xs-12'>
	<?php $form = ActiveForm::begin([
		'method'=>'get',
		'options' =>
			[
				'data-pjax' => 1,
			],
	]);
	?>
	<?= $form->errorSummary($model); ?>
	<div class="row">
		<div class="col-xs-3">
			Akun
			<?= Html::activeDropDownList($model,'akun_id',ArrayHelper::map($akuns,'id','nama'),['class'=>'form-control', 'prompt' => 'Pilih akun']); ?>
		</div>
		<div class='col-xs-3'>
			Mulai
			<?= Html::activeTextInput($model,'tanggal_awal',['id' => 'tanggal_awal','class'=>'form-control']); ?>
		</div>
		<div class='col-xs-3'>
			Akhir
			<?= Html::activeTextInput($model,'tanggal_akhir',['id' => 'tanggal_akhir','class'=>'form-control']); ?>
		</div>
		<div class='col-xs-3'>
			<br>
			<?= Html::submitButton('Proses',['class' => 'btn btn-success']); ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>
</div>
<br><br><br><br>

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
		$("#tanggal_awal").datetimepicker({
			timepicker: false,
			format: "Y-m-d",
		});
		$("#tanggal_akhir").datetimepicker({
			timepicker: false,
			format: "Y-m-d",
		});
	');
?>