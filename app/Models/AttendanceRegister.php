<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class AttendanceRegister extends Model
{
    use HasFactory;
    use HasFactory;
    use HasUuids;
    use SoftDeletes;
    
    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('register', function (Builder $query) {
                $query->where('attendance_registers.company_id', auth()->user()->company_id);
            });
        }
    }
}
