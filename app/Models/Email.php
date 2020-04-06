<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = [
        'subject', 'message', 'send_at', 'user_sender_id', 'contact_id'
    ];
}
