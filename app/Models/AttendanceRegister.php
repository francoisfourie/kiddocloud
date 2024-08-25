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
    use HasUuids;
    use SoftDeletes;
    
    protected $fillable = ['child_id', 'class_group_id', 'received_date', 'present', 'notes', 'company_id'];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }

    public function classGroup()
    {
        return $this->belongsTo(ClassGroup::class);
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
