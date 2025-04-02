<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\Department;
use App\Models\Catalogs\Province;
use App\Models\Catalogs\District;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'account_id',
        'identity_document_type_id',
        'number',
        'name',
        'trade_name',
        'email',
        'phone',
        'address',
        'department_id',
        'province_id',
        'district_id',
        'template_id',
        'logo_path',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function getAddressFullAttribute()
    {
        $address = ($this->address != '-') ? $this->address . ',' : '';
        return "{$address} {$this->department->description}, {$this->province->description}, {$this->district->description}";
    }

    public function getUbigeoAttribute()
    {
        return "{$this->department->description}, {$this->province->description}, {$this->district->description}";
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
