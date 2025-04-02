<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Catalogs\IdentityDocumentType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogs\Department;
use App\Models\Catalogs\District;
use App\Models\Catalogs\Province;


class Person extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'persons';

    protected $fillable = [
        'identity_document_type_id',
        'number',
        'name',
        'trade_name',
        'department_id',
        'province_id',
        'district_id',
        'address',
        'email',
        'phone'
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function identity_document_type()
    {
        return $this->belongsTo(IdentityDocumentType::class, 'identity_document_type_id');
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

    public function getUbigeoAttribute()
    {
        return "{$this->department->description}, {$this->province->description}, {$this->district->description}";
    }

    public function getAddressFullAttribute()
    {
        $address = trim($this->address);
        $address = ($address === '-' || $address === '') ? '' : $address . ' ,';
        if ($address === '') {
            return '';
        }
        return "{$address} {$this->department->description} - {$this->province->description} - {$this->district->description}";
    }


    public function quotations_where_customer()
    {
        return $this->hasMany(Quotation::class, 'customer_id');
    }

    public function getPersonDescription()
    {
        return "{$this->number} - {$this->name}";
    }


    public function scopeWhereFilterWithOutRelations($query)
    {
        return $query->withOut([
            'identity_document_type',
            'department',
            'province',
            'district'
        ]);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('number', 'like', '%' . $search . '%');
            ;
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
