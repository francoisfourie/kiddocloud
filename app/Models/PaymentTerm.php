<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class PaymentTerm extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function receivedPayments(): HasMany
    {
        return $this->hasMany(ReceivedPayment::class);
    }


    
    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('payment_term', function (Builder $query) {
                $query->where('company_id', auth()->user()->company_id);
            });
        }
    }

    // public static function rules(): array
    // {
    //     return [
           
    //         'name' => 'required|unique:payment_terms,name,NULL,id,company_id,' . auth()->company_id,
    //     ];
    // }
}
