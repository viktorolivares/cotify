<?php
namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\Person;

class IdentityDocumentType extends Model
{
    public $incrementing = false;
    protected $table = "identity_document_types";
    protected $casts = [
        'active' => 'bool'
    ];

    protected $fillable = [
        'id',
        'active',
        'description'
    ];

    /**
     * @return HasMany
     */
    public function companies_where_identity_document_type()
    {
        return $this->hasMany(Company::class, 'identity_document_type_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function people_where_identity_document_type()
    {
        return $this->hasMany(Person::class, 'identity_document_type_id', 'id');
    }

    /**
     * 
     * Filtrar tipos de documentos para usuarios
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopeFilterDataForPersons($query)
    {
        return $query->whereIn('id', ['0', '1', '4', '7']);
    }

}
