<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'recipient',
        'street1',
        'street2',
        'city',
        'state',
        'zip',
        'message',
        'image'
    ];
}
