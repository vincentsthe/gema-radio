<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\db\User */
/* @var $form yii\widgets\ActiveForm */
$model->password = null;
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['enableClientValidation' => true]); ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 100]) ?>

    <?= $form->field($model,'_verify_password')->passwordInput(['maxlength' => 100]); ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 100]) ?>

    <h4>Role</h4>
    <div class="col-xs-12">
        <div class="col-xs-2"><?= $form->field($model, 'is_admin')->checkBox() ?></div>
        <div class="col-xs-2"><?= $form->field($model, 'is_direktur')->checkBox() ?></div>
        <div class="col-xs-2"><?= $form->field($model, 'is_manajer')->checkBox() ?></div>
        <div class="col-xs-2"><?= $form->field($model, 'is_petugas')->checkBox() ?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>