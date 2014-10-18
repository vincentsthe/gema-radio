<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use app\assets\TimePickerAsset;
    use yii\helpers\Html;

    TimePickerAsset::register($this);


?>

<?php $form = ActiveForm::begin(['action'=>['index'],'method'=>'get']); ?>

<?= $form->field($model,'tanggal_awal')->textInput(['id'=>'tanggal_awal']); ?>
<?= $form->field($model,'tanggal_akhir')->textInput(['id' =>'tanggal_akhir']); ?>
<?= $form->field($model,'akun_id')->dropDownList(ArrayHelper::map($akuns,'id','nama')); ?>
<?= Html::submitButton('Search',['class' => 'btn btn-success']); ?>
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
