<?php
    use yii\grid\GridView;
    use yii\helpers\Html;
?>
<h2>Laporan Keuangan</h2>
<?=Html::a('Update laporan','update',['class'=>'btn btn-warning']); ?><br><br><br>
<div class="col-xs-8">
<table class="table table-striped table-condensed">
    <tr><th>Keterangan</th><th>Harga</th></tr>
    <?php foreach($rootAkuns as $rootakun) printRecursive($rootakun,0); ?>
</table>
</div>

<?php
    /**
     * @param Akun $model
     */
    function printRecursive($model,$depth){
        $childs = $model->getChilds()->all();
        if (count($childs) > 0){
            echo "<tr><td>".spaces($depth)."$model->nama</td><td></td></tr>";

            foreach($childs as $child){
                printRecursive($child,$depth+1);
            }

            echo "<tr><td>".spaces($depth)."Total $model->nama</td><td>$model->harga</td></tr>";
        } else {
            echo "<tr><td>".spaces($depth)."$model->nama</td><td>$model->harga</td></tr>";
        }
    }

    function spaces($depth){
        $result = '';
        while ($depth > 0){ $depth--; $result.='&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp'; }
        return $result;
    }
?>
