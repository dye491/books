<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 25.05.18
 * Time: 20:24
 */

namespace app\models;


use yii\base\Model;

class RegistrationForm extends Model
{
    public $email;
    public $password;
    public $passwordRepeat;
    public $firstName;
    public $surname;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'passwordRepeat', 'firstName'], 'required'],
            // email must be a valid email address
            [['email'], 'email'],
            // password is validated by validatePassword()
            [['password', 'passwordRepeat'], 'string', 'min' => 6],
            [['firstName', 'surname'], 'string', 'max' => 32],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email'          => 'email',
            'password'       => 'Пароль',
            'passwordRepeat' => 'Повторите пароль',
            'firstNme'       => 'Имя',
            'surname'        => 'Фамилия',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->firstName = $this->firstName;
        $user->surname = $this->surname;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $user->status = User::STATUS_DISABLED;

        return $user->save() ? $user : null;
    }
}