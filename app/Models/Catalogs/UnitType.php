<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    protected $table = "unit_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'symbol',
        'description',
    ];
}