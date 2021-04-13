<?php

namespace App\Repositories\Subscribers;

use App\Mails\CreateSubscriber;
use App\Models\Contacts\Contact;
use App\Models\Subscribers\Subscriber;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Mail;

class SubscriberRepository extends BaseRepository implements SubscriberRepositoryInterface
{
    public function __construct(Subscriber $subscriber)
    {
        parent::__construct($subscriber);
    }

    public function store(array $data): Model|static
    {
        $data = parent::store($data);

        // Lưu vào redis để schedule cập nhật lại subscriberCount của contact sau
        Redis::hIncrBy(Contact::REDIS_CONTACT_SUBSCRIBERS_COUNT, $data['contact_id'], 1);
        Mail::to($data->email)->queue(new CreateSubscriber());

        return $data;
    }
}
