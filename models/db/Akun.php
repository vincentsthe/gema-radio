<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "akun".
 *
 * @property integer $id
 * @property integer $nama
 *
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
            [['nama'], 'required'],
            [['nama'], 'integer']
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
        ];
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
}
