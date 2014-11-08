<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
?>
<h1>User</h1>
<?= Html::a("<span class='glyphicon glyphicon-plus'></span> Tambah user",'create',['class'=>'btn btn-primary']); ?>
<p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            	'label' => 'Name (job title)',
            	'value' => function ($model, $key, $index, $grid) {
            		return $model->fullname." (".$model->getRoleAsString().")";
            	}
            ],
            'username',
            [
            	//only show delete
            	'class' => 'yii\grid\ActionColumn',
            	'header' => 'Aksi',
            	'template' => '{delete}'
            ],
        ],
    ]); ?>
</p>
