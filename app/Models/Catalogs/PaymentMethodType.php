<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodType extends Model
{

    protected $table = "payment_method_types";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'active',
        'description',
    ];
}
