<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ReceivedPayment extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function paymentTerm(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('received_payments', function (Builder $query) {
                $query->where('company_id', auth()->user()->company_id);
            });
        }
    }
}
