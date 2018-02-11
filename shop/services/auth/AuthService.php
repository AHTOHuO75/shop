<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/25/17
 * Time: 10:50 AM
 */

namespace shop\services\auth;


use shop\entities\User\User;
use shop\forms\auth\LoginForm;
use shop\repositories\UserRepository;

class AuthService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth(LoginForm $form): User
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)){
            throw new \DomainException('Undefined user or password');
        }
        return $user;
    }
}