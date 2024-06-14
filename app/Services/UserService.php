<?php

namespace App\Services;

use App\Models\User;

final class UserService
{
    public function all(): \Illuminate\Database\Eloquent\Collection
    {
        return User::all();
    }
}