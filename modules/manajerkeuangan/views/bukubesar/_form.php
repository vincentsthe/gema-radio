<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use app\assets\TimePickerAsset;

    TimePickerAsset::register($this);


?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->errorSummary($model); ?>
<?= $form->field($model,'tanggal_awal')->textInput(['id'=>'tanggal_awal']); ?>
<?= $form->field($model,'tanggal_akhir')->textInput(['id' =>'tanggal_akhir']); ?>
<?= $form->field($model,'akun_id')->dropDownList(['1'=>'1']); ?>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(
    '   $("#tanggal_awal").datetimepicker({
            timepicker:false,
            format:"Y-m-d",
        });
        $("#tanggal_akhir").datetimepicker({
            timepicker:false,
            format:"Y-m-d",
        });',\yii\web\View::POS_READY);
?>
