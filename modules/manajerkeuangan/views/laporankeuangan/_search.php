<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use app\assets\TimePickerAsset;
    use yii\helpers\Html;

    TimePickerAsset::register($this);
    $url = \Yii::$app->urlManager->createUrl(['manajerkeuangan/laporankeuangan/index','jenis' => $jenis]);

?>
<!-- loading info -->
<div class='alert alert-info' id='loading' style="display:none">
    <h3>Loading ...</h3>
</div>

<div class='col-xs-12'>
<?php $form = ActiveForm::begin([
    'action'=>['index','jenis'=>$jenis],
    'method'=>'get',
    'options' => 
    [
        'onsubmit' => "return ajax_laporan(this)",
        'data-pjax' => 1,
    ],
]);
?>
<?= $form->errorSummary($model); ?>
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
        });',\yii\web\View::POS_READY);
?>
<?php

$this->registerJs("function ajax_laporan(form_html){
    $('#loading').show();
    return true;
}",\yii\web\View::POS_HEAD);
?>
