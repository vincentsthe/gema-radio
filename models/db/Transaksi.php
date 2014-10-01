<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "transaksi".
 *
 * @property integer $id
 * @property string $nama
 * @property string $tanggal
 * @property integer $no_order
 * @property string $produk
 * @property integer $nominal
 * @property string $terbilang
 * @property integer $jumlah_siaran
 * @property integer $siaran_per_hari
 * @property integer $teks_spot
 * @property string $deskripsi
 * @property string $jenis_transaksi
 * @property integer $akun_id
 *
 * @property Rekaman[] $rekamen
 * @property Siaran[] $siarans
 * @property Akun $akun
 */
class Transaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'tanggal', 'nominal', 'terbilang', 'jumlah_siaran', 'siaran_per_hari', 'teks_spot', 'deskripsi', 'jenis_transaksi'], 'required'],
            [['tanggal'], 'safe'],
            [['no_order', 'nominal', 'jumlah_siaran', 'siaran_per_hari', 'teks_spot', 'akun_id'], 'integer'],
            [['deskripsi', 'jenis_transaksi'], 'string'],
            [['nama', 'produk'], 'string', 'max' => 100],
            [['terbilang'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'tanggal' => 'Tanggal',
            'no_order' => 'No Order',
            'produk' => 'Produk',
            'nominal' => 'Nominal',
            'terbilang' => 'Terbilang',
            'jumlah_siaran' => 'Jumlah Siaran',
            'siaran_per_hari' => 'Siaran Per Hari',
            'teks_spot' => 'Teks Spot',
            'deskripsi' => 'Deskripsi',
            'jenis_transaksi' => 'Jenis Transaksi',
            'akun_id' => 'Akun ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRekamen()
    {
        return $this->hasMany(Rekaman::className(), ['transaksi_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiarans()
    {
        return $this->hasMany(Siaran::className(), ['transaksi_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkun()
    {
        return $this->hasOne(Akun::className(), ['id' => 'akun_id']);
    }
}
