<?php

namespace app\models\db;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $fullname
 * @property integer $is_admin
 * @property integer $is_direktur
 * @property integer $is_manajer
 * @property integer $is_petugas
 * @property integer $login_trial
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'fullname'], 'required'],
            [['is_admin', 'is_direktur', 'is_manajer', 'is_petugas', 'login_trial'], 'integer'],
            [['username', 'password', 'fullname'], 'string', 'max' => 100],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'fullname' => 'Fullname',
            'is_admin' => 'Is Admin',
            'is_direktur' => 'Is Direktur',
            'is_manajer' => 'Is Manajer',
            'is_petugas' => 'Is Petugas',
            'login_trial' => 'Login Trial',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username){
        return User::find()->where(['username' => $username])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new Exception("Unsupported operation exception");
        
        //return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        //throw new Exception("Unsupported operation exception");
    }

    public function validateAuthKey($authKey)
    {
        //throw new Exception("Unsupported operation exception");
    }

    public function validatePassword($password){
        return $this->password === sha1($password);
    }

    public function isAdmin(){ return $this->is_admin; }
    public function isDirektur(){ return $this->is_direktur; }
    public function isManajerKeuangan(){ return $this->is_manajer; }
    public function isPetugas(){ return $this->is_petugas; }

}
