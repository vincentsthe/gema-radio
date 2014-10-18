<?php
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;

    echo Nav::widget([
        'options' => ['class' => 'nav nav-tabs'],
        'items' => [
            ['label' => 'Buku Tabungan Hari Tua', 'url' => ['/manajerkeuangan/tabungan-hari-tua/listtabungan']],
            ['label' => 'Transaksi Tabungan', 'url' => ['/manajerkeuangan/tabungan-hari-tua/add']],
        ],
    ]);
?>