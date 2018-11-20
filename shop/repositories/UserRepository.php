<?php

namespace shop\repositories;

use shop\entities\User;

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

    public function getByPasswordResetToken($token): User
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function get($id): User
    {
        return $this->getBy(['id' => $id]);
    }

    public function existsByPasswordResetToken(string $token): User
    {
        return User::findByPasswordResetToken($token);
    }

    public function save(User $user)
    {
        if (!$user->save()) {
            throw new \RuntimeException('Saving error');
        }
    }

    private function getBy(array $condition): User
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }

    public function findByUsernameOrEmail($value): User
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email'=> $value]])->one();
    }

    public function findByNetworkIdentity($network, $identity): User
    {
        return User::find()->joinWith('network n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }
}