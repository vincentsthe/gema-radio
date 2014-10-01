<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "rekaman".
 *
 * @property integer $id
 * @property integer $transaksi_id
 * @property string $tanggal
 * @property string $waktu_deadline
 *
 * @property Transaksi $transaksi
 */
class Rekaman extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rekaman';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'transaksi_id', 'tanggal', 'waktu_deadline'], 'required'],
            [['id', 'transaksi_id'], 'integer'],
            [['tanggal', 'waktu_deadline'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'transaksi_id' => 'Transaksi ID',
            'tanggal' => 'Tanggal',
            'waktu_deadline' => 'Waktu Deadline',
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
    public function queryToday($durations)
    {
        $currentDate = date('Y-m-d');
        $currentTime = date('h:i:s');
        return self::find()
            ->with(['transaksi' => function($query) {
                $query->select(['deskripsi']);
            }])
            ->orderBy(['transaksi_id']);
    }
}
