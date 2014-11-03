<?php
    use yii\grid\GridView;
    use app\assets\OverlayAsset;
    use app\assets\SiaranAsset;

    OverlayAsset::register($this);
    SiaranAsset::register($this);
?>
<h2>Siaran</h2>
<?=$this->render('_tabs'); ?>
<br>

<?php foreach($list as $hour=>$listSiaran): ?>
    <div id="jam<?= $hour; ?>">
        <hr>
        <h4><?= $hour . ":00 - " . $hour . ":59" ?></h4>
        <table class="table table-striped">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Deskripsi</th>
                <th>Checklist</th>
            </tr>
            <?php $i=1 ?>
            <?php foreach($listSiaran as $siaran): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $siaran->transaksi->nama; ?></td>
                    <td><?= $siaran->transaksi->jenis_transaksi; ?></td>
                    <td><a onClick="createAlert(<?= $siaran->id ?>)">Lihat Deskripsi</a></td>
                    <td><input id="<?= $siaran->id ?>" type="checkbox"></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br><br><br>
    </div>
<?php endforeach; ?>