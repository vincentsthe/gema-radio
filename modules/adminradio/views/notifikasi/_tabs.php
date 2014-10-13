<?php 
	use yii\bootstrap\Nav;
?>

<?=Nav::widget([
	    'options' => ['class' => 'nav nav-tabs'],
	    'items' => [
	        ['label' => 'Siaran', 'url' => ['/adminradio/notifikasi/siaran']],
	        ['label' => 'Rekaman', 'url' => ['/adminradio/notifikasi/rekaman']],
	    ],
	]);
?>