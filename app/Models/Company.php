<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Child::class);
    }

    public function paymentTerms(): HasMany
    {
        return $this->hasMany(PaymentTerm::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('company', function (Builder $query) {
                $query->where('id', auth()->user()->company_id);
                // or with a `team` relationship defined:
                //$query->whereBelongsTo(auth()->user()->company_id);
            });
        }
    }
    
}
