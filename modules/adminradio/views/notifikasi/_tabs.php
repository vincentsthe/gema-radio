<?php 
	use yii\bootstrap\Nav;
	use yii\helpers\Html;
?>
<?= Html::beginForm(null,'get'); ?>
<div class="col-xs-8 col-xs-offset-4">
	<div class="col-xs-4">
		<label class="control-label" for="duration">Update setiap (menit)</label>
	</div>
	<div class="col-xs-4">
		<?= Html::textInput('duration',$duration,['class'=>'form-control']); ?>
	</div>
	<div class="col-xs-2">
		<?= Html::submitButton('refresh',['class'=>'btn btn-success']); ?>
	</div>
</div>
<div style="clear:both;"></div>
<?= Html::endForm(); ?>


<?=Nav::widget([
	    'options' => ['class' => 'nav nav-tabs'],
	    'items' => [
	        ['label' => 'Siaran', 'url' => ['/adminradio/notifikasi/siaran']],
	        ['label' => 'Rekaman', 'url' => ['/adminradio/notifikasi/rekaman']],
	    ],
	]);
?>
