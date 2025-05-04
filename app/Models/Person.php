<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people'; // اگر جدول people است
    protected $fillable = [
        'account_code', 'company', 'title', 'first_name', 'last_name', 'nickname', 'category_id', 'type',
        'credit', 'price_list', 'tax_type', 'national_id', 'economic_code', 'register_no', 'branch_code',
        'description', 'address', 'country', 'state', 'city', 'postal_code', 'phone', 'mobile', 'fax',
        'phone1', 'phone2', 'phone3', 'email', 'website', 'birthday', 'marriage_date', 'join_date', 'avatar'
    ];

    public function banks()
    {
        return $this->hasMany(BankAccount::class);
    }
}
