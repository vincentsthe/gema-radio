<?php
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use app\helpers\TimeHelper;
    echo Nav::widget([
        'options' => ['class' => 'nav nav-tabs'],
        'items' => [
            ['label' => 'Buku Tabungan Hari Tua', 'url' => ['/manajerkeuangan/tabungan-hari-tua/listtabungan','startDate'=>TimeHelper::getBeginningYear(TimeHelper::getTodayDate()),'endDate'=>TimeHelper::getEndYear(TimeHelper::getTodayDate())]],
            ['label' => 'Transaksi Tabungan', 'url' => ['/manajerkeuangan/tabungan-hari-tua/add']],
        ],
    ]);
?>