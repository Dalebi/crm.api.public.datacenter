<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'description',
        'order',
        'color',
        'active'
    ];
}
