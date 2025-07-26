<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicPort extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'id_data_center',
        'active'
    ];
}
