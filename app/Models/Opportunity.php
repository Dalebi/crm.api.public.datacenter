<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    protected $table = 'opportunities';

    protected $fillable = [
        'corporate_id',
        'contact_id',
        'consultant_id',
        'name',
        'status',
        'file',
        'active',
    ];
}
