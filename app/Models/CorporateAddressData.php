<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateAddressData extends Model
{
    use HasFactory;
    protected $fillable = [
        'corporate_id',
        'street',
        'state',
        'country',
    ];

}
