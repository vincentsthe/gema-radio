<?php 
	use yii\bootstrap\Nav;
	use yii\helpers\Html;
?>

<?=Nav::widget([
	    'options' => ['class' => 'nav nav-tabs'],
	    'items' => [
	        ['label' => 'Siaran', 'url' => ['/adminradio/notifikasi/siaran']],
	        ['label' => 'Rekaman', 'url' => ['/adminradio/notifikasi/rekaman']],
	    ],
	]);
?>
