<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
    use app\helpers\FormatHelper;
    use app\models\db\TransaksiLain;
?>


<h2>Buku Besar</h2>
<br>
<?= $this->render('_search',['model'=>$model,'akuns' => $akuns]); ?><br>
<div class='col-xs-6 col-xs-offset-6'>
<table class='table table-condensed pull-right'>
    <tr><td>Keadaan awal: (<?=$model->tanggal_awal?>) </td><td><?=FormatHelper::currency($debit - $kredit);?></td></tr>
</table>
</div>
<?php $total = $debit - $kredit; ?>
<?=GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        //'id',
        'tanggal',
        'deskripsi',
        [
            'label' => 'Ref',
            'value' => function($model) {
                return $model->nomor;
            }
        ],
        [
            'class' => 'yii\grid\DataColumn',
            'label' => 'Nominal',
            'value' => function($model,$key,$index,$column) use(&$total){
                $nominal = (($model->jenis_transaksi == TransaksiLain::DEBIT)?1:-1)*$model->nominal;
                $total += $nominal;

                $color = ($nominal >= 0)?'green':'red';
                return "<span class='pull-right $color'>" . FormatHelper::currency($nominal) . "</span>";
            },
            'format' => 'html',
        ],
    ],
]);
?>
<div class='col-xs-6 col-xs-offset-6'>
<table class='table table-condensed pull-right'>
    <tr><td>Saldo Akhir (<?=$model->tanggal_akhir?>)</td><td class="green"><?=FormatHelper::currency($total);?></td></tr>
</table>
</div>
<?= "Dari tanggal $model->tanggal_awal hingga $model->tanggal_akhir : <br/>"; ?>
<?= Html::a('Export to CSV',['print','startDate' => $model->tanggal_awal,'endDate'=> $model->tanggal_akhir,'akun_id' => $model->akun_id],['class'=>'btn btn-primary','target'=>'_blank']); ?>
&nbsp;<?= Html::a('Export all',['print-all','startDate' => $model->tanggal_awal,'endDate'=> $model->tanggal_akhir],['id'=>'print-all','class'=>'btn btn-primary','onclick'=>'return click_all()']); ?>
<?php foreach($akuns as $akun) {
    echo Html::a('',['print','startDate' => $model->tanggal_awal,'endDate'=>$model->tanggal_akhir,'akun_id' => $akun->id],['class'=>'print-clicker']);
}
?>
<?php $this->registerJs("
function click_all(){
    $('.print-clicker').each(function(){
        var loc = $(this).attr('href');
        window.open(loc,'_blank');
    });
    return false;
};",\yii\web\View::POS_HEAD);
?>
