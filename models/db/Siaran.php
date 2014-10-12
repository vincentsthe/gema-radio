<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "siaran".
 *
 * @property integer $id
 * @property string $tanggal
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
            [['tanggal', 'transaksi_id', 'waktu_mulai', 'waktu_selesai'], 'required'],
            [['tanggal', 'waktu_mulai', 'waktu_selesai'], 'safe'],
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
            'tanggal' => 'tanggal',
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

    /**
     * @var int $duration duration of time in minutes
     * @return ActiveQuery Instance
     */
    public static function queryToday($durations)
    {
        $currentDate = date('Y-m-d');
        $currentTime = date('h:i:s');
        return self::find()
            ->with(['transaksi' => function($query) {
                $query->select(['deskripsi']);
            }])
            ->where("`waktu_mulai`>= ".($currentTime + $durations))
            ->where("`tanggal` = '".$currentDate."'")
            ->orderBy(['transaksi_id' => SORT_ASC]);
    }


}
