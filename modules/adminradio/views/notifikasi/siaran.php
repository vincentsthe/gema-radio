<?php
    use yii\grid\GridView;

?>

<?=$this->render('_tabs'); ?>
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
    //reload each 30 seconds
    window.setTimeout('location.reload()',30*1000);
</script>
