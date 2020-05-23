<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'ip',
        'account_id',
        'loan_id',
        'account_user_id_receiver',
        'account_user_id_doer',
        'message',
        'details'
    ];

    protected $casts = [
        'details' => 'collection'
    ];
}
