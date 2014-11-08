<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\web\Session;
	$session = new Session(); $session->open();
?>

<h1>Ganti Password</h1>
<?php $form = ActiveForm::begin(['enableClientValidation' => true]); ?>
<?= $form->errorSummary($model); ?>

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

<?= $form->field($model,'oldPassword')->passwordInput(); ?>
<?= $form->field($model,'newPassword')->passwordInput(); ?>
<?= $form->field($model,'repeatNewPassword')->passwordInput(); ?>
<?= Html::submitButton('Simpan',['class' => 'btn btn-primary']); ?>
<?php ActiveForm::end(); ?>
