<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/29/17
 * Time: 10:33 PM
 */

namespace frontend\services\auth;


use common\entities\User;
use frontend\forms\SignupForm;

class SignupService
{
    public function signup(SignupForm $form): User
    {
        $user = User::signup(
            $form->username,
            $form->email,
            $form->password
        );

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }

        return $user;
    }
}