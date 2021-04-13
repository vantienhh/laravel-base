<?php

namespace App\Models\Subscribers;

use Illuminate\Database\Eloquent\Builder;

trait FilterTrait
{
    public function scopeName(Builder $query, $name): Builder
    {
        return $query->where('name', 'like', "%${name}%");
    }

    public function scopeEmail(Builder $query, $email): Builder
    {
        return $query->where('email', $email);
    }

    public function scopePhone(Builder $query, $phone): Builder
    {
        return $query->where('phone', $phone);
    }

    public function scopeContactId(Builder $query, $contactId): Builder
    {
        return $query->where('contact_id', $contactId);
    }
}
