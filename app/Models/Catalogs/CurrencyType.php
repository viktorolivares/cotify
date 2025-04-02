<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{

    protected $table = "currency_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'symbol',
        'description',
    ];

    public function scopeActives($query)
    {
        return $query->where('active', 1);
    }
}
