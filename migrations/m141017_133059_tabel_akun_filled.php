<?php

use yii\db\Schema;
use yii\db\Migration;

class m141017_133059_tabel_akun_filled extends Migration
{
    public function safeUp()
    {
        echo "adding column `kode` in `akun`";
        $this->addColumn('akun','kode','varchar(32) DEFAULT NULL');
        echo "adding data in column `akun`";
        $this->addAkunData();
        return true; 
    }  

    public function safeDown()
    {
        echo "deleteing all `akun` entry";
        $this->delete('akun');
        echo "drop column `kode` in `akun`";
        $this->dropColumn('akun','kode');
        return true;
    }

    /**
     * add all akun record
     */
    protected function addAkunData(){
        $this->batchInsert('akun',['id', 'nama', 'parent', 'harga', 'kode'],
        [
            [1, 'Transaksi', 0, 0, NULL],
            [3, 'Aktiva', 0, 0, NULL],
            [5, 'Aktiva Lancar', 3, 0, NULL],
            [6, 'Kas', 5, 0, '111'],
            [7, 'Bank', 5, 0, '112'],
            [8, 'Piutang', 5, 0, '113'],
            [9, 'Aktiva Tetap', 3, 0, NULL],
            [10, 'Hibah', 9, 0, NULL],
            [11, 'Saham', 10, 0, '1211'],
            [12, 'Tanah', 10, 0, '1212'],
            [13, 'Gedung', 10, 0, '1213'],
            [14, 'Barang Kantor', 10, 0, '1214'],
            [15, 'Barang Elektronik', 10, 0, '1215'],
            [16, 'Pembelian', 9, 0, NULL],
            [17, 'Saham BPR RASUNA', 16, 0, '1221'],
            [18, 'Tanah', 16, 0, '1222'],
            [19, 'Gedung', 16, 0, '1223'],
            [20, 'Barang Kantor', 16, 0, '1224'],
            [21, 'Barang Elektronik', 16, 0, '1225'],
            [22, 'Akumulasi Penyusutan Aktiva Tetap', 9, 0, NULL],
            [23, 'Saham BPR Rasuna', 22, 0, '1231'],
            [24, 'Tanah', 22, 0, '1232'],
            [25, 'Gedung', 22, 0, '1233'],
            [26, 'Barang Kantor', 22, 0, '1234'],
            [27, 'Barang Elektronik', 22, 0, '1235'],
            [28, 'Pasiva', 0, 0, NULL],
            [29, 'Pasiva Lancar', 28, 0, NULL],
            [30, 'Hutang', 29, 0, '211'],
            [31, 'Beban Segera Dibayar', 29, 0, '212'],
            [32, 'Selisih Kas', 29, 0, '213'],
            [33, 'Pendapatan yang masih akan diterima', 29, 0, '214'],
            [34, 'Cadangan', 28, 0, NULL],
            [35, 'Cadangan Umum', 34, 0, '221'],
            [36, 'Cadangan Tujuan', 34, 0, '222'],
            [37, 'Modal', 0, 0, NULL],
            [38, 'Modal Disetor', 37, 0, '31'],
            [39, 'Modal Tambahan', 37, 0, '32'],
            [40, 'Modal Hibah', 37, 0, '33'],
            [41, 'Pendapatan Usaha', 0, 0, NULL],
            [42, 'Iklan', 41, 0, '41'],
            [43, 'Barang Kehilangan', 41, 0, '42'],
            [44, 'Pengumuman', 41, 0, '43'],
            [45, 'Hasil Rekaman', 41, 0, '44'],
            [46, 'Non air', 41, 0, '45'],
            [47, 'Biaya Usaha', 0, 0, NULL],
            [48, 'Produksi Siaran', 47, 0, '51'],
            [49, 'Sumber Daya Manusia', 47, 0, '52'],
            [50, 'Administrasi Umum', 47, 0, '53'],
            [51, 'Humas dan Promosi', 47, 0, '54'],
            [52, 'Litbang', 47, 0, '55'],
            [53, 'Penyusutan', 47, 0, '56'],
            [54, 'Pendapatan Diluar Usaha', 0, 0, NULL],
            [55, 'Jasa Bank', 54, 0, '61'],
            [56, 'Devident Saham Lain', 54, 0, '62'],
            [57, 'Lain-lain', 54, 0, '63'],
            [58, 'Biaya Diluar Usaha', 0, 0, NULL],
            [59, 'Administrasi Bank', 58, 0, '71'],
            [60, 'Bunga Pinjaman', 58, 0, '72'],
            [61, 'Lain-lain', 58, 0, '73']
        ]);

    }
    
}
