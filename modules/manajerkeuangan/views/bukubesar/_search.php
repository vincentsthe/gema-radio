<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use app\assets\TimePickerAsset;
    use yii\helpers\Html;

    TimePickerAsset::register($this);


?>
<div class='col-xs-12'>
<?php $form = ActiveForm::begin(['action'=>['index'],'method'=>'get']); ?>
<?= $form->errorSummary($model); ?>

    <div class='col-xs-3'>
        Akun <?= Html::activeDropDownList($model,'akun_id',ArrayHelper::map($akuns,'id','nama'),['class'=>'form-control', 'prompt' => 'Pilih akun']); ?>
        
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

<?php ActiveForm::end(); ?>
</div>
<br><br><br>
<?php
$this->registerJs(
    '   $("#tanggal_awal").datetimepicker({
            timepicker:false,
            format:"Y-m-d",
        });
        $("#tanggal_akhir").datetimepicker({
            timepicker:false,
            format:"Y-m-d",
        });
        ',\yii\web\View::POS_READY);
?>
