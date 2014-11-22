<?php

namespace app\models\db;

use Yii;

use app\helpers\ConstantHelper;
use app\models\factory\TabunganHariTuaFactory;

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
    const DEBIT = 'debit';
    const KREDIT = 'kredit';
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
            [['kegiatan', 'jenis_transaksi', 'tanggal', 'nominal', 'terbilang', 'akun_id'], 'required'],
            [['akun_id', 'nominal'], 'integer'],
            [['jenis_transaksi'], 'string'],
            [['tanggal'], 'safe'],
            [['kegiatan'], 'string', 'max' => 100],
            [['terbilang'], 'string', 'max' => 300],
            [['deskripsi'], 'string', 'max' => 256],
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
            'deskripsi' => 'Deskripsi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkun()
    {
        return $this->hasOne(Akun::className(), ['id' => 'akun_id']);
    }

    public function beforeSave() {
        if(($this->isNewRecord) && (ConstantHelper::getTabunganHariTuaId() == $this->akun_id)) {
            $tabungan = TabunganHariTuaFactory::createTabunganHariTuaFromTransaksi($this);
            $tabungan->save();
        }

        return parent::beforeSave(true);
    }
}
