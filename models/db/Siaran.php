<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "siaran".
 *
 * @property integer $id
 * @property string $tanngal
 * @property integer $transaksi_id
 * @property string $waktu_mulai
 * @property string $waktu_selesai
 *
 * @property Transaksi $transaksi
 */
class Siaran extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'siaran';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanngal', 'transaksi_id', 'waktu_mulai', 'waktu_selesai'], 'required'],
            [['tanngal', 'waktu_mulai', 'waktu_selesai'], 'safe'],
            [['transaksi_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanngal' => 'Tanngal',
            'transaksi_id' => 'Transaksi ID',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransaksi()
    {
        return $this->hasOne(Transaksi::className(), ['id' => 'transaksi_id']);
    }
}
