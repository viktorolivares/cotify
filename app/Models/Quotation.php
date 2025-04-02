<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

use App\Models\Catalogs\PaymentMethodType;
use App\Models\Catalogs\CurrencyType;
use App\Models\Catalogs\StateType;
use App\Models\QuotationItem;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'external_id',
        'establishment_id',
        'state_type_id',
        'prefix',
        'date_of_issue',
        'date_of_due',
        'delivery_date',
        'customer_id',
        'currency_type_id',
        'payment_method_type_id',
        'exchange_rate_sale',
        'total_charge',
        'total_discount',
        'total_igv',
        'subtotal',
        'total',
        'filename',
    ];

    protected $casts = [
        'date_of_issue' => 'date',
        'date_of_due' => 'date',
        'delivery_date' => 'date',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->hasOneThrough(Company::class, Establishment::class, 'id', 'id', 'establishment_id', 'company_id');
    }

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }

    public function state_type(): BelongsTo
    {
        return $this->belongsTo(StateType::class);
    }

    public function payment_method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethodType::class, 'payment_method_type_id');
    }

    public function currency_type(): BelongsTo
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id');
    }

    public function getIdentifierAttribute()
    {
        return $this->prefix . '-' .'000'. $this->id;
    }

    public function scopeWhereStateTypeAccepted($query)
    {
        return $query->whereIn('state_type_id', ['01']);
    }

    public function getStringDeliveryDate()
    {
        if (empty($this->delivery_date)) {
            return null;
        }
        if (is_string($this->delivery_date)) {
            return $this->delivery_date;
        }
        return $this->delivery_date->format('d-m-Y');
    }

    public function getTransformTotal()
    {
        return ($this->currency_type_id === 'PEN') ? $this->total : ($this->total * $this->exchange_rate_sale);
    }

    public function hasStateTypeAccepted()
    {
        return in_array($this->state_type_id, ['03']);
    }

    public function hasStateTypeRejected()
    {
        return in_array($this->state_type_id, ['04']);
    }


    public function getDocumentTypeDescription()
    {
        return 'COTIZACIÓN';
    }

    public function getUrlPrintPdf($format = "a4")
    {
        return url("quotations/print/{$this->external_id}/{$format}");
    }

    public function scopeOrderByDateOfIssueDesc($query)
    {
        return $query->orderBy('date_of_issue', 'desc');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('prefix', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhereRaw("CONCAT(prefix, '-', id) LIKE ?", ["%{$search}%"]);
            });
        })->when($filters['date_start'] ?? null, function ($query, $date_start) {
            $query->where('date_of_issue', '>=', $date_start);
        })->when($filters['date_end'] ?? null, function ($query, $date_end) {
            $query->where('date_of_issue', '<=', $date_end);
        })->when($filters['company_search'] ?? null, function ($query, $companySearch) {
            $query->whereHas('establishment.company', function ($query) use ($companySearch) {
                $query->where('name', 'like', '%' . $companySearch . '%')
                    ->orWhere('address', 'like', '%' . $companySearch . '%');
            });
        })->when($filters['customer_search'] ?? null, function ($query, $customerSearch) {
            $query->whereHas('person', function ($query) use ($customerSearch) {
                $query->where('name', 'like', '%' . $customerSearch . '%')
                    ->orWhere('email', 'like', '%' . $customerSearch . '%');
            });
        });
    }


}
