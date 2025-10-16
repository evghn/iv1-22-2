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
    public $password_repeat;
    public $phone;
    public $rule;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        /*
        Пользователю необходимо предоставить возможность ввести 
        +уникальный логин
        + (латиница и цифры, не менее 6 символов), 
        
        + пароль (минимум 8 символов), 
        + ФИО (символы
кириллицы и пробелы),
         телефон (формат: 8(XXX)XXX-XX-XX), 
        + адрес электронной почты        (формат: электронной почты)
        */
        return [
            [['full_name', 'login', 'password', 'email', 'phone', 'password_repeat'], 'required'],
            [['full_name', 'login', 'password', 'email', 'phone'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 8],
            [['login'], 'string', 'min' => 6],
            [['email'], 'email'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

            // ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Логин должен содержать латиница и цифры, не менее 6 символов'],
            // ['login', 'match', 'pattern' => '/^[a-z\d]+$/i', 'message' => 'Логин должен содержать латиница и цифры, не менее 6 символов'],

            // ['full_name', 'match', 'pattern' => '/^[а-яА-ЯёЁ\s]+$/u', 'message' => 'ФИО должно содержать символы кириллицы и пробелы'],
            ['full_name', 'match', 'pattern' => '/^[а-яё\s]+$/iu', 'message' => 'ФИО должно содержать символы кириллицы и пробелы'],

            // ФИО содержит кирилицу и не менее 2-ух пробелов
            ['full_name', 'match', 'pattern' => '/^[а-яё]+\s[а-яё]+\s([а-яё\s]+)$/iu', 'message' => 'ФИО должно содержать символы кириллицы и не менее 2-ух пробелов'],

            // ['phone', 'match', 'pattern' => '/^8\([\d]{3}\)[\d]{3}\-[\d]{2}\-[\d]{2}$/', 'message' => 'телефон (формат: 8(XXX)XXX-XX-XX)'],
            ['phone', 'match', 'pattern' => '/^8\([\d]{3}\)[\d]{3}(\-[\d]{2}){2}$/', 'message' => 'телефон (формат: 8(XXX)XXX-XX-XX)'],

            [['login'], 'unique', 'targetClass' => User::class],
            ['rule', 'boolean'],
            ['rule', 'required', 'requiredValue' => 1, 'message' => 'Заполните согласие с обработкой....'],

            // обязательное присутствие хотя бы одной буквы в верхнем и нижнем регистре латинского алфавита (login || password) остальные символы не определены
            // [['login', 'password'], 'match', 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z]).+$/', 'message' => 'обязательное присутствие хотя бы одной буквы в верхнем и нижнем регистре латинского алфавита'],

            // обязательное присутствие хотя бы одной буквы в верхнем и нижнем регистре латинского алфавита (login || password) + цифра остальные символы не определены
            [['login', 'password'], 'match', 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d]).+$/', 'message' => 'обязательное присутствие хотя бы одной буквы в верхнем и нижнем регистре латинского алфавита и цифры'],

            // обязательное присутствие хотя бы одной буквы в верхнем и нижнем регистре латинского алфавита (login || password) + цифра остальные символы латинский алфавит + цифры
            [['login', 'password'], 'match', 'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d])[a-zA-Z\d]+$/', 'message' => 'обязательное присутствие хотя бы одной буквы в верхнем и нижнем регистре латинского алфавита и цифры'],



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
            'password_repeat' => 'Повтор пароля',
            'email' => 'Адрес электронной почты',
            'phone' => 'Телефон',
            'rule' => 'Согласие с обработкой....',

        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function register(): User | bool
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
        }
        return $user ?? false;
    }
}
