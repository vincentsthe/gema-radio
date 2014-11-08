<?php 
	use yii\bootstrap\Nav;
	use yii\helpers\Html;
?>

<?=Nav::widget([
	    'options' => ['class' => 'nav nav-tabs'],
	    'items' => [
	        ['label' => 'Transaksi Berdasarkan Siaran', 'url' => ['/petugas/transaksi/createnewtransaksisiaran']],
	        ['label' => 'Transaksi Berdasarkan Periode', 'url' => ['/petugas/transaksi/createnewtransaksiperiode']],
	    ],
	]);
?>
