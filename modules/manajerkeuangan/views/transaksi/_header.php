<?php
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;

    echo Nav::widget([
        'options' => ['class' => 'nav nav-tabs'],
        'items' => [
            ['label' => 'Transaksi Lain', 'url' => ['/manajerkeuangan/transaksi/add']],
            ['label' => 'Tambah Akun Transaksi', 'url' => ['/manajerkeuangan/transaksi/akun']],
        ],
    ]);
    echo "<hr>";
?>