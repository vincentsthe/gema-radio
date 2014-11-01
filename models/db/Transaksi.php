<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "transaksi".
 *
 * @property integer $id
 * @property string $nama
 * @property string $tanggal
 * @property integer $no_order
 * @property string $produk
 * @property integer $nominal
 * @property string $terbilang
 * @property integer $jumlah_siaran
 * @property integer $siaran_per_hari
 * @property string $deskripsi
 * @property string $jenis_transaksi
 *
 * @property Rekaman[] $rekamen
 * @property Siaran[] $siarans
 */
class Transaksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'transaksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['siaran_per_hari', 'required',
                'when' => function($model) {
                    return $model->jenis_siaran == "periodik";
                },
                'whenClient' => 'function(attribute, value) {
                    return ($("#jenis_siaran").val == "periodik");
                }'
            ],
            ['interval', 'required',
                'when' => function($model) {
                    return $model->jenis_siaran == "periodik";
                },
                'whenClient' => 'function(attribute, value) {
             		return ($("#jenis_siaran").val == "periodik");
                }'
         	],
            ['jumlah_siaran', 'required',
            	'when' => function($model) {
            		return $model->jenis_siaran == "per_siaran";
            	},
            	'whenClient' => 'function(attribute, value) {
                	return ($("#jenis_siaran").val == "per_siaran");
            	}'
            ],
            [['nama', 'tanggal', 'nominal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'jenis_periode'], 'required'],
            [['nama', 'tanggal', 'terbilang', 'deskripsi', 'jenis_transaksi', 'periode_awal', 'periode_akhir', 'no_order'], 'string'],
            [['siaran_per_hari', 'jumlah_siaran', 'interval'], 'integer'],
            [['tanggal'], 'safe'],
            [['nama', 'produk'], 'string', 'max' => 100],
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
            'nama' => 'Nama',
            'tanggal' => 'Tanggal',
            'no_order' => 'No Order',
            'produk' => 'Produk',
            'nominal' => 'Nominal',
            'terbilang' => 'Terbilang',
            'jumlah_siaran' => 'Jumlah Siaran',
            'siaran_per_hari' => 'Siaran Per Hari',
            'deskripsi' => 'Deskripsi',
            'jenis_transaksi' => 'Jenis Transaksi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRekaman()
    {
        return $this->hasMany(Rekaman::className(), ['transaksi_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSiarans()
    {
        return $this->hasMany(Siaran::className(), ['transaksi_id' => 'id']);
    }
}
