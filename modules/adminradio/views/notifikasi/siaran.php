<?php
    use yii\grid\GridView;

?>
<h2>Siaran</h2>
<?=$this->render('_tabs',['duration'=>$duration]); ?>
<br>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'waktu_mulai',
        'waktu_selesai',
        'transaksi.deskripsi',

        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

<script type="text/javascript">
    //reload each duration seconds
    window.setTimeout('location.reload()',<?=$duration;?>*60*1000);
</script>
