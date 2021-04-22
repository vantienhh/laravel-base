<?php

namespace App\Repositories\Contacts;

use App\Models\Contacts\Contact;
use App\Repositories\BaseRepository;
use App\Contracts\Contact\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $contact)
    {
        parent::__construct($contact);
    }

    public function incrementSubscribersCount($id, $count): void {
        $record = $this->getById($id);

        $record->increment('subscribers_count', $count);
    }

}
