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
            [['nama', 'harga', 'parent'], 'required'],
            [['parent', 'harga'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama Akun',
            'parent' => 'Klasifikasi Akun',
            'harga' => 'Harga',
            'kode' => 'Kode Akun',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return self::find()->where(['id'=>$this->parent]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return self::find()->where(['parent' => $this->id]);
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
     * update harga hanya berdasarkan anak2nya tepat di bawahnya/transaksi
     */
    public function updateHarga(){
        //if leaf
        if ($this->getChilds()->count() == 0){
            $debit = $this->getTransaksiLains()->where('jenis_transaksi="debit"')->sum('nominal');
            $kredit = $this->getTransaksiLains()->where('jenis_transaksi="kredit"')->sum('nominal');
            if($debit == NULL) {
                $debit = 0;
            }
            if($kredit == NULL) {
                $kredit = 0;
            }

            $this->harga = $debit - $kredit;
        } else {
            $this->harga = $this->getChilds()->sum('harga');
        }
        if (!$this->save()){
            var_dump($this->getErrors());
            throw new Exception("Error Processing Request", 1);
        }
        
    }

    public function queryLeaf() {
        return Akun::find()
            ->where('kode IS NOT NULL')
            ->all();
    }

    /**
     * update harga dengan anak2nya ikut diupdate
     */
    public function updateDFS(){
        $childs = $this->getChilds()->all();
        foreach($childs as $child){
            $child->updateDFS();
        }
        $this->updateHarga();
    }

    /**
     * WARNING: sangat costly
     */
    public static function updateAllHarga(){
        $roots = self::find()->where(['parent'=>0])->all();
        foreach($roots as $root){
            $root->updateDFS();
        }
    }

}
