<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'description',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
