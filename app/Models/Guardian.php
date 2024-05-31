<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guardian extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    
     public function children(): BelongsToMany
     {
    //     return $this->belongsToMany(Guardian::class, 'children_guardians', 'guardian_id', 'child_id');
    // //   return $this->belongsToMany(Child::class)
    // //   ->withPivot('child_id')
    // //   ->using(ChildGuardian::class);
        return $this->belongsToMany(Child::class);
     }

    //  public function getFullNameAttribute(): string
    //  {
    //      return $this->first_name . ' ' . $this->surname;
    //  }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->surname}";
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('employee', function (Builder $query) {
                $query->where('company_id', auth()->user()->company_id);
            });
        }
    }

    // Searchable attributes
       public static function getGloballySearchableAttributes(): array
       {
           return ['first_name'];
       }

       public function childrenNames()
       {
           return "abc,qaz";
       }


}
