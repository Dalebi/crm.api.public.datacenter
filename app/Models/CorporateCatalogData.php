<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorporateCatalogData extends Model
{
    use HasFactory;

    protected $fillable = [
        'corporate_id',
        'corporate_catalog_id',
        'value'
    ];
}
