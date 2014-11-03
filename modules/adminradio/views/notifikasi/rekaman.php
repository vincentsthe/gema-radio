<?php
    use app\assets\OverlayAsset;
    use app\assets\RekamanAsset;

    OverlayAsset::register($this);
    RekamanAsset::register($this);
?>
<h2>Rekaman</h2>
<?=$this->render('_tabs'); ?>
<br>

<?php foreach($list as $hour=>$listRekaman): ?>
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
            <?php foreach($listRekaman as $rekaman): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $rekaman->transaksi->nama; ?></td>
                    <td><?= $rekaman->transaksi->jenis_transaksi; ?></td>
                    <td><a onClick="createAlert(<?= $rekaman->id ?>)">Lihat Deskripsi</a></td>
                    <td><input id="<?= $rekaman->id ?>" type="checkbox"></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br><br><br>
    </div>
<?php endforeach; ?>