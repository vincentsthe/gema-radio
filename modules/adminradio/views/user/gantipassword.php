<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\Session;
$session = new Session(); $session->open();
?>
<?php $form = ActiveForm::begin(['enableClientValidation' => true]); ?>
<?= $form->errorSummary($model); ?>

<?= $session->getFlash('message'); ?>
<?= $form->field($model,'oldPassword')->passwordInput(); ?>
<?= $form->field($model,'newPassword')->passwordInput(); ?>
<?= $form->field($model,'repeatNewPassword')->passwordInput(); ?>
<?= Html::submitButton('Simpan',['class' => 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>
