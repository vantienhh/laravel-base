<?php

namespace App\Http\Transformers;

use App\Models\Contacts\Contact;
use League\Fractal\TransformerAbstract;

class ContactTransformer extends TransformerAbstract
{
    protected array $availableIncludes = [
    ];

    public function transform(Contact $contact = null): array
    {
        if (is_null($contact)) {
            return [];
        }

        return [
            'id'                => $contact->id,
            'name'              => $contact->name,
            'description'       => $contact->description,
            'subscribers_count' => $contact->subscribers_count,
        ];
    }

}
