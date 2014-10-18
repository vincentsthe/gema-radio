<?php

namespace app\models\db;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tabungan_hari_tua".
 *
 * @property integer $id
 * @property string $tanggal
 * @property string $jenis_kegiatan
 * @property integer $nominal
 * @property string $jenis_transaksi
 */
class TabunganHariTua extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tabungan_hari_tua';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal', 'jenis_kegiatan', 'nominal', 'jenis_transaksi'], 'required'],
            [['tanggal'], 'safe'],
            [['nominal'], 'integer'],
            [['jenis_transaksi'], 'string'],
            [['jenis_kegiatan'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
            'jenis_kegiatan' => 'Jenis Kegiatan',
            'nominal' => 'Nominal',
            'jenis_transaksi' => 'Jenis Transaksi',
        ];
    }

    public static function getTotalDebit() {
        $debit = (new Query)
                    ->select(['sum(nominal) AS debit'])
                    ->from('tabungan_hari_tua')
                    ->where('jenis_transaksi="debit"')
                    ->all();
        return $debit[0]["debit"];
    }

    public static function getTotalKredit() {
        $kredit = (new Query)
                    ->select(['sum(nominal) AS kredit'])
                    ->from('tabungan_hari_tua')
                    ->where('jenis_transaksi="kredit"')
                    ->all();
        return $kredit[0]["kredit"];
    }
}
