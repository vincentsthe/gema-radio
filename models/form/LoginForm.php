<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\db\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            if ($this->getUser()->login_trial > 0){
                $this->resetLoginTrial();
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            } else {
                $this->addError('username','Percobaan login sudah habis');
            }
            
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }


    public function decreaseLoginTrial(){
        $user = User::find()->where(['username' => $this->username])->one();
        if ($user){
            $user->login_trial--;
            $user->save();
        }
        
        
    }

    public function resetLoginTrial() {
        $user = User::find()->where(['username' => $this->username])->one();
        if ($user){
           $user->login_trial = User::DEFAULT_LOGIN_TRIAL;
            $user->save();
        }
    
    }
}
