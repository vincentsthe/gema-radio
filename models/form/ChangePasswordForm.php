<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\db\User;

/**
 * LoginForm is the model behind the login form.
 */
class ChangePasswordForm extends Model
{
    public $id; //user id
    public $oldPassword;
    public $newPassword;
    public $repeatNewPassword;

    private $_user;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['id','oldPassword','newPassword','repeatNewPassword'], 'required'],
            [['id'], 'integer'],
            // rememberMe must be a boolean value
            [['oldPassword','newPassword','repeatNewPassword'], 'string', 'max' => 100],
            ['oldPassword','validatePassword'],

            ['repeatNewPassword','compare','compareAttribute' => 'newPassword' , 'message' => 'Password tidak sama'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Password lama',
            'newPassword' => 'Password baru',
            'repeatNewPassword' => 'Ulangi Password',
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::find()->where(['id' => $this->id])->one();
        }
        return $this->_user;
    }

    public function validatePassword($attribute,$params){
        $user = $this->getUser();
        //die(User::findOne($this->id));
        if (($user !== null) && ($user->password === sha1($this->oldPassword))){
            return true;
        } else {
            $this->addError($attribute,"Password lama: ".$user->password." cek dengan".sha1($this->oldPassword));
            return false;
        };
    }

    public function updatePassword(){
        $user = $this->getUser();
        $user->password = sha1($this->newPassword);
        return $user->save();
    }
}
