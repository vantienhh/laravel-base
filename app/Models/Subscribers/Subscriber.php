<?php

namespace App\Models\Subscribers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscriber
 *
 * @property int       id
 * @property string    name
 * @property string    email
 * @property string    phone
 * @property int       contact_id
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property \DateTime deleted_at
 *
 * @mixin Subscriber
 */
class Subscriber extends Model
{
    use SoftDeletes, FilterTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'contact_id'
    ];
}
