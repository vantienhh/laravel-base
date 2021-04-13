<?php

namespace App\Http\Transformers;

use App\Models\Subscribers\Subscriber;
use League\Fractal\TransformerAbstract;

class SubscriberTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    public function transform(Subscriber $subscriber = null): array
    {
        if (is_null($subscriber)) {
            return [];
        }

        return [
            'id'    => $subscriber->id,
            'name'  => $subscriber->name,
            'email' => $subscriber->email,
            'phone' => $subscriber->phone,
        ];
    }

}
