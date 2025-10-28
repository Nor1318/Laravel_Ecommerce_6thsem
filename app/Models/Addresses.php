<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'country',
        'postal_code',
        'is_default',
    ];

    public function setIsDefaultAttribute($value)
    {
        if ($value) {
            self::where('user_id', $this->user_id)->update(['is_default' => false]);
        }
        $this->attributes['is_default'] = $value;
    }
}
