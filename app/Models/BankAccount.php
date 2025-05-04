<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['person_id', 'bank', 'account', 'card', 'sheba'];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
