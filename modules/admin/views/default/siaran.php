<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Siarans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siaran-index">

    <?php
        NavBar::begin([
            'options' => [
                'class' => 'navbar navbar-tabs',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'nav navbar-nav'],
            'items' => [
                ['label' => 'Siaran', 'url' => ['/admin/default/siaran']],
                ['label' => 'Rekaman', 'url' => ['/admin/default/rekaman']],
            ],
        ]);
        NavBar::end();
    ?>

    <h1>Siaran</h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'Jam Siaran',
                'value'=>function($data) {
                    return $data->waktu_mulai . ' - ' . $data->waktu_selesai;
                },
            ],
            'waktu_mulai',
            'waktu_selesai',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
