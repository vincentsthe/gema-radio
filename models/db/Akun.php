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

    public function getParentAkun(){
        return $this->hasOne(Akun::className(),['parent' => 'id'])->from(['parent_akun' => 'akun']);
    }

    public function getChildAkuns(){
        return $this->hasMany(Akun::className(),['id'=>'parent'])->from(['child_akun'=>'akun']);
    }

    /**
     * update harga hanya berdasarkan anak2nya tepat di bawahnya/transaksi
     */
    public function updateHarga($tanggal_awal,$tanggal_akhir){
        //if leaf
        if ($this->getChilds()->count() == 0){
            $debit = $this->getTransaksiLains()->andWhere('jenis_transaksi="debit"')->andWhere(['between','tanggal',$tanggal_awal,$tanggal_akhir])->sum('nominal');
            $kredit = $this->getTransaksiLains()->andWhere('jenis_transaksi="kredit"')->andWhere(['between','tanggal',$tanggal_awal,$tanggal_akhir])->sum('nominal');
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

    public static function findNeraca(){
        return self::find()->andWhere(['in','nama',['Aktiva','Pasiva','Modal']]);
    }

    public static function findLabaRugi(){
        return self::find()->andWhere(['not in','nama',['Aktiva','Pasiva','Modal']]);
    }


    public static function getLeafs(){
        $data = self::find()->all();
        $retval = [];
        foreach($data as $akun) {
            if ($akun->getChilds()->count() == 0){
                array_push($retval,$akun);
            }
        }
        return $retval;
    }

}
