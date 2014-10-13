<?php
    use yii\grid\GridView;

?>
<h2>Rekaman</h2>
<?=$this->render('_tabs',['duration'=>$duration]); ?>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'tanggal',
        'transaksi.deskripsi',
        'finished'
        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

<script type="text/javascript">
    //reload each seconds
    window.setTimeout('location.reload()',<?=$duration;?>*60*1000);
</script>
