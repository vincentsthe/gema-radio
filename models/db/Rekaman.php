<?php

namespace app\models\db;

use Yii;
use app\helpers\TimeHelper;

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
            [['transaksi_id', 'waktu'], 'required'],
            [['transaksi_id'], 'integer'],
            [['tanggal', 'waktu'], 'safe']
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
