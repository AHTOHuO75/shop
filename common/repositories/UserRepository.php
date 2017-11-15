<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/14/17
 * Time: 9:51 PM
 */

namespace common\repositories;


use common\entities\User;

class UserRepository
{
    public function getByEmailConfirmToken($token): User
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }


    public function getByEmail($email): User
    {
        return $this->getBy(['email' => $email]);
    }

    public function existByPasswordResetToken(string $token): bool
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function save(User $user): void
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }

}