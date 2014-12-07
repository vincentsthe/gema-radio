<?php 
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
?>

<?php $this->beginContent('@app/views/layouts/layout.php'); ?>
    <div class="row">
        <div class="col-md-3 sidebar">
            <?php
                if(isset(Yii::$app->user->identity) && (Yii::$app->user->identity->isAdmin())) {
                    echo '<h5>Menu Utama</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Ganti Password', 'url' => ['/user/changepassword','id'=>Yii::$app->user->identity->id]],
                        ],
                    ]);
                }
            ?>
            <?php
                if(isset(Yii::$app->user->identity) && (Yii::$app->user->identity->isAdmin())) {
                    echo '<h5>Menu Admin</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Notification', 'url' => ['/adminradio/notifikasi/siaran']],
                            ['label' => 'User Management', 'url' => ['/adminradio/user/index']],
                        ],
                    ]);
                }
            ?>

            <?php
                if(isset(Yii::$app->user->identity) && (Yii::$app->user->identity->isDirektur())) {
                    echo '<h5>Menu Direktur</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Notification', 'url' => ['/adminradio/notifikasi']],
                            ['label' => 'Buku Besar', 'url' => ['/manajerkeuangan/bukubesar']],
                            ['label' => 'Laporan Keuangan', 'url' => ['/manajerkeuangan/laporankeuangan']],
                            ['label' => 'Buku Tabungan Hari Tua', 'url' => ['/manajerkeuangan/tabungan-hari-tua/listtabungan']],
                            ['label' => 'Konfigurasi Pengguna', 'url' => ['/manajerkeuangan/user/index']],
                        ],
                    ]);
                }
            ?>

            <?php
                if(isset(Yii::$app->user->identity) && (Yii::$app->user->identity->isManajerKeuangan())) {
                    echo '<h5>Menu Bagian Keuangan</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Konfirmasi Post Akun', 'url' => ['/manajerkeuangan/transaksi/listunconfirmed']],
                            ['label' => 'Edit Transaksi Biasa', 'url' => ['/manajerkeuangan/transaksi/listedit']],
                            ['label' => 'Input Post Akun', 'url' => ['/manajerkeuangan/transaksi/newadd']],
                            ['label' => 'Daftar Transaksi', 'url' => ['/manajerkeuangan/transaksi/listtransaction']],
                            ['label' => 'Buku Besar', 'url' => ['/manajerkeuangan/bukubesar/index']],
                            ['label' => 'Laporan Keuangan', 'url' => ['/manajerkeuangan/laporankeuangan/index']],
                            ['label' => 'Buku Tabungan Hari Tua', 'url' => ['/manajerkeuangan/tabungan-hari-tua/listtabungan']],
                            ['label' => 'Konfigurasi Pengguna', 'url' => ['/manajerkeuangan/user/index']],
                        ],
                    ]);
                }
            ?>

            <?php
                if(isset(Yii::$app->user->identity) && (Yii::$app->user->identity->isPetugas())) {
                    echo '<h5>Menu Petugas</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Transaksi Biasa', 'url' => ['/petugas/transaksi/createnewtransaksisiaran']],
                            ['label' => 'Ubah Password', 'url' => ['/petugas/default/changepassword']],
                        ],
                    ]);
                }
            ?>
        </div>

        <div id="main-content" class="col-md-9">
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>