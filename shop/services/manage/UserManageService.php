<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/10/18
 * Time: 3:40 PM
 */

namespace shop\services\manage;

use shop\entities\User;
use shop\forms\manage\User\UserEditForm;
use shop\repositories\UserRepository;
use shop\forms\manage\User\UserCreateForm;

class UserManageService
{
    private $repository;

    public function __construct(UserRepository $repository)
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

    public function edit($id, UserEditForm $form)
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email
        );
        $this->repository->save($user);
    }

}