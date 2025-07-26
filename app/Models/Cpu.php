<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cpu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'id_disk_1',
        'id_disk_2',
        'id_public_port',
        'id_transfer',
        'id_data_center',
        'active'
    ];

}
