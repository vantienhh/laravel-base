<?php

namespace App\Contracts\Contact;

use App\Contracts\Base\BaseRepositoryInterface;

interface ContactRepositoryInterface extends BaseRepositoryInterface
{
    public function incrementSubscribersCount($id, $count): void;
}
