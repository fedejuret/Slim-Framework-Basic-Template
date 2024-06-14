<?php

namespace App\Service;

use App\Model\User;

final class UserService
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }
}