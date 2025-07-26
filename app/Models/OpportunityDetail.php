<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityDetail extends Model
{
    use HasFactory;
    protected $table = 'opportunities_detail';

    protected $fillable = [
        'opportunity_id',
        'folio',
        'description',
    ];
}
