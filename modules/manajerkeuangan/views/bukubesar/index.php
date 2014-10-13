<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
?>
<h2>Buku Besar</h2>
<br>
<?= $this->render('_form',['model'=>$model]); ?>
<?php /*GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'fullname',
        'username',
        [
            'label' => 'Password',
            'class' => 'yii\grid\DataColumn',
            'value' => function($model,$key,$index,$column){
                    return Html::a('reset',['/adminradio/user/resetpassword','id'=>$model->id]);
                },
            'format' => 'html'
        ]

        //['class' => 'yii\grid\ActionColumn'],
    ],
]); */?>
