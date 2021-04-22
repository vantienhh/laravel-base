<?php

namespace App\Console\Commands;

use App\Models\Contacts\Contact;
use App\Contracts\Contact\ContactRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UpdateContactSubscriberCountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contact-update:subscriberCount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update subscriber count of the contacts';

    protected ContactRepositoryInterface $contactRepo;

    /**
     * Create a new command instance.
     *
     * @param ContactRepositoryInterface $contact
     */
    public function __construct(ContactRepositoryInterface $contact)
    {
        parent::__construct();
        $this->contactRepo = $contact;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $contactsSubscriberCount = Redis::hGetAll(Contact::REDIS_CONTACT_SUBSCRIBERS_COUNT);

        foreach ($contactsSubscriberCount as $contactId => $subscriberCount) {
            if ($subscriberCount > 0) {
                $this->contactRepo->incrementSubscribersCount($contactId, $subscriberCount);
                Redis::hIncrBy(Contact::REDIS_CONTACT_SUBSCRIBERS_COUNT, $contactId, -$subscriberCount);
            }
        }
    }
}
