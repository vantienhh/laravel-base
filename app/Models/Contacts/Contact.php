<?php

namespace App\Models\Contacts;

use Database\Factories\ContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Contact
 *
 * @property int       id
 * @property string    name
 * @property string    description
 * @property int       subscribers_count
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 *
 * @mixin Contact
 */
class Contact extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'subscribers_count'
    ];

    protected static function newFactory()
    {
        return ContactFactory::new();
    }

    const REDIS_CONTACT_SUBSCRIBERS_COUNT = 'subscribersCount';

}
