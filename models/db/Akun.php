<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "akun".
 *
 * @property integer $id
 * @property integer $nama
 * @property integer $parent
 * @property integer $harga
 *
 * @property Akun $parent0
 * @property Akun[] $akuns
 * @property Transaksi[] $transaksis
 * @property TransaksiLain[] $transaksiLains
 */
class Akun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'akun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'parent', 'harga'], 'required'],
            [['nama', 'parent', 'harga'], 'integer']
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
            'parent' => 'Parent',
            'harga' => 'Harga',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Akun::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAkuns()
    {
        return $this->hasMany(Akun::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksis()
    {
        return $this->hasMany(Transaksi::className(), ['akun_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksiLains()
    {
        return $this->hasMany(TransaksiLain::className(), ['akun_id' => 'id']);
    }

    /**
     * update harga dengan query ke transaksi
     * memakan waktu cukup lama
     */
    public function updateHarga(){
        $this->harga = self::getTransaksis()
            ->select(['sum(nominal)'])
            ->groupBy($this->id)
            ->all();
        $this->save();
    }
}
