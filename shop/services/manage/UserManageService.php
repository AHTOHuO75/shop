<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 1/21/18
 * Time: 4:03 PM
 */

namespace shop\services\manage;


use shop\entities\User\User;
use shop\forms\manage\User\UserCreateForm;
use shop\forms\manage\User\UserEditForm;
use shop\repositories\UserRepository;

class UserManageService
{
    private $repository;

    public function __construct(
        UserRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );
        $this->repository->save($user);
        return $user;
    }

    public function edit($id, UserEditForm $form): void
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );
        $this->repository->save($user);
    }

}