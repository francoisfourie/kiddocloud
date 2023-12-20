<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

     public $appends = ['annual_leave_taken'];

    // public function getFullNameAttribute(): string
    // {
    //     return $this->name . ' ' . $this->surname;
    // }

    public function getAnnualLeaveTakenAttribute($type): string
    {
        return $this->hasMany(LeaveApplication::class)->where('leave_type','annual leave')
        ->whereBetween('start_date', [
            Carbon::now()->startOfYear(),
            Carbon::now()->endOfYear(),])
        ->sum('leave_days');
    }

    // public function getLeaveTakenAttribute($type): 
    // {
    //     return $this->hasMany(LeaveApplication::class)->where('leave_type','annual_leave')->sum('leave_days');
    // }

    // public function getLeaveTakenAttribute(): string
    // {
    //     //this->leaveApplications->su
    //     return $this->leaveApplications::sum('leave_days');
        
    // }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    
    public function employeeType(): BelongsTo
    {
        return $this->belongsTo(EmployeeType::class);
    }

    public function leaveApplications(): HasMany
    {
        return $this->hasMany(LeaveApplication::class);
    }

    public static function getByType($descr)
    {

        $type = EmployeeType::where('descr', $descr)->first();
        $employees = Employee::where('employee_type_id', $type->id)->get();
        
        return $employees;
        // $type = 'teacher';
        // $employees = Employee::whereHas('type', function ($query) use ($type) {
        //     $query->where('descr', $type);
        // })->get();
        // return $employees;
       // $type = EmployeeType::where('descr', 'teacher')->first();

        //$employees = $type->employees;
        //return $employees;
        //return Employee::where('employee_type_id',2)->get();
    }

    // public function type(): HasOne
    // {
    //     return $this->hasOne(EmployeeType::class);
    // }


    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('employee', function (Builder $query) {
                $query->where('company_id', auth()->user()->company_id);
            });
        }
    }

}
