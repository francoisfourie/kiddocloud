<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    
    public $appends = ['full_name'];

    // protected function fullName(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (mixed $value, array $attributes) => new Address(
    //             $attributes['address_line_one'],
    //             $attributes['address_line_two'],
    //         ),
    //     );
    // }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->surname;
    }

    // protected function fullName(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (mixed $value, array $attributes) => new Address(
    //             $attributes['address_line_one'],
    //             $attributes['address_line_two'],
    //         ),
    //     );
    // }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function classGroups(): BelongsTo
    {
        return $this->belongsTo(ClassGroup::class,'class_group_id');
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class);
    }

    public function receivedPayments(): HasMany
    {
        return $this->hasMany(ReceivedPayment::class);
    }

    public function hasReceivedPaymentsForTerm(PaymentTerm $paymentTerm): bool
    {
        //$found = $this->receivedPayments()->where('payment_term_id', $paymentTerms->id)->count();
        $receivedPayments = $this->receivedPayments()->where('payment_term_id', $paymentTerm->id)->count();
        return 0 < $receivedPayments ;
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('employee', function (Builder $query) {
                $query->where('children.company_id', auth()->user()->company_id);
            });
        }
    }
    
}
