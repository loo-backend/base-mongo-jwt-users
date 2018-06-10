<?php

namespace App\Repositories\User;

use App\Interfaces\IRepository;

interface UserRepositoryInterface extends IRepository
{
    public function search($data);
}
