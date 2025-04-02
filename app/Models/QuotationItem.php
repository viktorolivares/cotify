<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\{
    AffectationIgvType,
    SystemIscType,
    PriceType
};

class QuotationItem extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'quotation_id',
        'name',
        'description',
        'unit_type_id',
        'affectation_igv_type_id',
        'includes_igv',
        'quantity',
        'unit_value',
        'unit_price',
        'discount',
        'charge',
        'igv',
        'subtotal',
        'total',
    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    // Métodos de acceso para atributos JSON
    public function getItemAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setItemAttribute($value)
    {
        $this->attributes['item'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getChargesAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setChargesAttribute($value)
    {
        $this->attributes['charges'] = (is_null($value)) ? null : json_encode($value);
    }

    public function getDiscountsAttribute($value)
    {
        return (is_null($value)) ? null : (object) json_decode($value);
    }

    public function setDiscountsAttribute($value)
    {
        $this->attributes['discounts'] = (is_null($value)) ? null : json_encode($value);
    }

    // Relaciones
    public function affectation_igv_type()
    {
        return $this->belongsTo(AffectationIgvType::class, 'affectation_igv_type_id');
    }

    public function system_isc_type()
    {
        return $this->belongsTo(SystemIscType::class, 'system_isc_type_id');
    }

    public function price_type()
    {
        return $this->belongsTo(PriceType::class, 'unit_type_id');
    }
}
