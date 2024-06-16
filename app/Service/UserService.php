<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\User;
use Illuminate\Database\Eloquent\Collection;

final class UserService
{
    public function all(): Collection
    {
        return User::all();
    }
}
