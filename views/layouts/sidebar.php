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
                if(1) {                             //if admin TODO change this
                    echo '<h5>Menu Admin</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Notification', 'url' => ['/admin/default/siaran']],
                            ['label' => 'User Management', 'url' => ['/user/index']],
                            ['label' => 'Settings', 'url' => ['/user/index']],
                        ],
                    ]);
                }
            ?>

            <?php
                if(1) {                             //if direktur TODO change this
                    echo '<h5>Menu Direktur</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Notification', 'url' => ['/siaran/index']],
                            ['label' => 'Buku Besar', 'url' => ['/user/index']],
                            ['label' => 'Laporan Keuangan', 'url' => ['/user/index']],
                            ['label' => 'Buku Tabungan Hari Tua', 'url' => ['/user/index']],
                            ['label' => 'Konfigurasi Pengguna', 'url' => ['/user/index']],
                            ['label' => 'Ubah Password', 'url' => ['/user/index']],
                        ],
                    ]);
                }
            ?>

            <?php
                if(1) {                             //if Manajer Keuangan TODO change this
                    echo '<h5>Menu Manajer Keuangan</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Konfirmasi', 'url' => ['/siaran/index']],
                            ['label' => 'Transaksi', 'url' => ['/user/index']],
                            ['label' => 'Ubah', 'url' => ['/user/index']],
                            ['label' => 'Buku Besar', 'url' => ['/user/index']],
                            ['label' => 'Laporan Keuangan', 'url' => ['/user/index']],
                            ['label' => 'Buku Tabungan Hari Tua', 'url' => ['/user/index']],
                            ['label' => 'Konfigurasi Pengguna', 'url' => ['/user/index']],
                            ['label' => 'Ubah Password', 'url' => ['/user/index']],
                        ],
                    ]);
                }
            ?>

            <?php
                if(1) {                             //if Petugas TODO change this
                    echo '<h5>Menu Petugas</h5>';
                    echo Nav::widget([
                        'options' => ['class' => 'nav nav-sidebar'],
                        'items' => [
                            ['label' => 'Transaksi', 'url' => ['/petugas/default/createTransaksi']],
                            ['label' => 'Ubah Password', 'url' => ['/user/index']],
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