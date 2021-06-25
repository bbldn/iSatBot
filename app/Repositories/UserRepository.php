<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        /** @var User|null $user */
        $user = User::find($id);

        return $user;
    }

    /**
     * @param string $login
     * @return User|null
     */
    public function findOneByLogin(string $login): ?User
    {
        /** @var User|null $user */
        $user = User::where(User::login, $login)->first();

        return $user;
    }
}