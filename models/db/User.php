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
    const DEFAULT_LOGIN_TRIAL = 3;

    //index role to be converted to is_admin etc
    public $_verify_password;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['register'] = ['_verify_password', 'password','username','fullname','is_admin','is_direktur','is_manajer','is_petugas'];
        return $scenarios;
    }

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
            [['username', 'password', 'fullname','_verify_password'], 'string', 'max' => 100],
            [['username'], 'unique'],
            
            [['_verify_password'], 'required', 'on'=>'register'],
            [['_verify_password'], 'compare', 'compareAttribute' => 'password','on'=>'register'],
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
            'is_admin' => 'Admin',
            'is_direktur' => 'Direktur',
            'is_manajer' => 'Manajer',
            'is_petugas' => 'Petugas',
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

    /**
     * @return string
     */
    public function getRoleAsString(){
        if ($this->isAdmin()) return "Admin";
        else if ($this->isDirektur()) return "Direktur";
        else if ($this->isManajerKeuangan()) return "Manajer Keuangan";
        else return "Petugas";
    }

}
