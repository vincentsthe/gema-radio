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
            [['nama', 'tanggal', 'nominal', 'terbilang', 'teks_spot', 'deskripsi', 'jenis_transaksi'], 'required'],
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
    public function getRekaman()
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
    public function getParent()
    {
        return $this->hasOne(Akun::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(Akun::className(),['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis(){
        return $this->hasMany(Transaksi::className(),['id'=>'akun_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiLains(){
       return $this->hasMany(TransaksiLain::className(), ['akun_id' => 'id']);
    }

    /**
     * @var int $akun_id id akun
     * @var time $tanggal_mulai
     * @var time $tanggal_selesai
     */
    public static function queryBukuBesar($akun_id,$tanggal_mulai,$tanggal_selesai){
        return self::find()
            ->where(['akun_id' => $akun_id])
            ->where(['between','tanggal',$tanggal_mulai,$tanggal_selesai])
            ->orderBy(['id']);
    }

    /**
     * @var int $akun_id
     * @return ActiveQuery
     */
    public static function queryAkun($akun_id){
        return self::find()
            ->where(['akun_id' => $akun_id])
            ->groupBy($akun_id);
    }

    


}
