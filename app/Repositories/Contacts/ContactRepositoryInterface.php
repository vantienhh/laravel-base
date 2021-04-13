<?php

namespace App\Repositories\Contacts;

use App\Repositories\BaseRepositoryInterface;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    public function incrementSubscribersCount($id, $count): void;
}
