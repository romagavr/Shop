<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/7/18
 * Time: 5:39 PM
 */

namespace shop\services\auth;


use shop\entities\User;
use shop\repositories\UserRepository;

class NetworkService
{
    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function auth($network, $identify): User
    {
        if ($user = $this->users->findByNetworkIdentity($network, $identify)) {
            return $user;
        }
        $user = User::signupByNetwork($network, $identify);
        $this->users->save($user);
        return $user;
    }
}