<?php

namespace app\models\db;

use Yii;
use app\helpers\TimeHelper;

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
            [['tanggal', 'transaksi_id', 'waktu'], 'required'],
            [['tanggal', 'waktu'], 'safe'],
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
            'waktu' => 'Waktu',
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
    public static function queryToday()
    {
        $currentDate = date('Y-m-d');
        $currentTime = TimeHelper::getBeginningHourTime();
        return self::find()
            ->with(['transaksi'])
            ->where("`waktu` >= '".($currentTime)."'")
            ->andWhere("`tanggal` = '".$currentDate."'")
            ->orderBy(['waktu' => SORT_ASC]);
    }


}
