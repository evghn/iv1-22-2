<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

class RegisterForm extends Model
{
    public $full_name;
    public $login;
    public $email;
    public $password;
    public $phone;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'password', 'email', 'phone'], 'required'],

            [['full_name', 'login', 'password', 'email', 'phone'], 'string', 'max' => 255],
            // [['login'], 'unique'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Адрес электронной почты',
            'phone' => 'Телефон',

        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function register(): bool
    {
        if ($this->validate()) {
            $user = new User();
            $user->load($this->attributes, '');
            $user->password = Yii::$app->security->generatePasswordHash($user->password);
            $user->auth_key = Yii::$app->security->generateRandomString();

            if (!$user->save()) {
                VarDumper::dump($user->errors, 10, true);
                die;
            }



            return true;
        }
        return false;
    }
}
