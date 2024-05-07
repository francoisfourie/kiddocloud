<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassGroup extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    // public function teacher(): HasOne
    // {
    //     return $this->hasOne(Employee::class); //expand this to include only teachers
    // }


    public function teacher()
    {
        return $this->belongsTo(Employee::class, 'teacher_id');
    }

    // public function assistant(): HasOne
    // {
    //     return $this->hasOne(Employee::class); //expand this to only include assistants
    // }

    
    public function assistant()
    {
        return $this->belongsTo(Employee::class, 'assistant_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }


    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('employee', function (Builder $query) {
                $query->where('company_id', auth()->user()->company_id);
            });
        }
    }
}
