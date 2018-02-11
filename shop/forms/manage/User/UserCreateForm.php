<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/21/18
 * Time: 4:08 PM
 */

namespace shop\forms\manage\User;


use shop\entities\User\User;
use yii\base\Model;

class UserCreateForm extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules(): array
    {
        return [
            [['username', 'email'], 'required'],
            ['email', 'email'],
            [['username', 'email'], 'string', 'max' => 255],
            [['username', 'email'], 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 6],
        ];
    }


}