<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "transaksi_lain".
 *
 * @property integer $id
 * @property string $kegiatan
 * @property integer $akun_id
 * @property string $jenis_transaksi
 * @property string $tanggal
 * @property integer $nominal
 * @property string $terbilang
 *
 * @property Akun $akun
 */
class TransaksiLain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi_lain';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'kegiatan', 'jenis_transaksi', 'tanggal', 'nominal', 'terbilang'], 'required'],
            [['id', 'akun_id', 'nominal'], 'integer'],
            [['jenis_transaksi'], 'string'],
            [['tanggal'], 'safe'],
            [['kegiatan'], 'string', 'max' => 100],
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
            'kegiatan' => 'Kegiatan',
            'akun_id' => 'Akun ID',
            'jenis_transaksi' => 'Jenis Transaksi',
            'tanggal' => 'Tanggal',
            'nominal' => 'Nominal',
            'terbilang' => 'Terbilang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkun()
    {
        return $this->hasOne(Akun::className(), ['id' => 'akun_id']);
    }
}
