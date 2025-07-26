<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCorporate extends Model
{
    use HasFactory;

    protected $table = 'contact_corporate';

    protected $fillable = [
        'corporate',
        'contact',
        'active'
    ];
}
