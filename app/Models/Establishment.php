<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $table = 'establishments';
    protected $fillable = [
        'company_id',
        'department_id',
        'province_id',
        'district_id',
        'description',
        'address',
        'email',
        'phone',
        'code',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->firstOrFail();
    }


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getAddressFullAttribute()
    {
        $address = ($this->address != '-') ? $this->address . ' ,' : '';
        return "{$address} {$this->department->description} - {$this->province->description} - {$this->district->description}";
    }

    public function scopeFilterDataForTables($query)
    {
        return $query->whereFilterWithOutRelations()->select('id', 'description');
    }

    public function scopeOrderByDescription($query)
    {
        $query->orderBy('description');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('description', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            });
        })->when($filters['enabled'] ?? null, function ($query, $enabled) {
            if ($enabled === 'true') {
                $query->where('enabled', true);
            } else if ($enabled === 'false') {
                $query->where('enabled', false);
            }
        })->when($filters['with_deleted_companies'] ?? null, function ($query, $with_deleted_companies) {
            if ($with_deleted_companies === 'with') {
                $query->whereHas('company', function ($query) {
                    $query->withTrashed();
                });
            } elseif ($with_deleted_companies === 'only') {
                $query->whereHas('company', function ($query) {
                    $query->onlyTrashed();
                });
            }
        });
    }
}
