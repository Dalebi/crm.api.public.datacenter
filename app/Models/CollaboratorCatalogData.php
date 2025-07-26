<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaboratorCatalogData extends Model
{
    use HasFactory;

    protected $fillable = [
        'collaborator_id',
        'collaborator_catalog_id',
        'value'
    ];
}
