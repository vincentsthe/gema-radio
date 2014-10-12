<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transaksis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaksi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Transaksi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nama',
            'tanggal',
            'no_order',
            'produk',
            // 'nominal',
            // 'terbilang',
            // 'jumlah_siaran',
            // 'siaran_per_hari',
            // 'teks_spot',
            // 'deskripsi:ntext',
            // 'jenis_transaksi',
            // 'akun_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
