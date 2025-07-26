<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorCatalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'description',
        'order',
        'required',
        'active'
    ];
}
