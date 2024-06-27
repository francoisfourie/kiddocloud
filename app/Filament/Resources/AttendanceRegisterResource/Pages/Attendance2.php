<?php

namespace App\Filament\Resources\AttendanceRegisterResource\Pages;

use App\Filament\Resources\AttendanceRegisterResource;
use Filament\Resources\Pages\Page;
use App\Models\Child;
use App\Models\AttendanceRegister;
use Illuminate\Http\Request;

class Attendance extends Page
{
    protected static string $resource = AttendanceRegisterResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationGroup = 'AttendanceCustom';


    protected static string $view = 'filament.resources.attendance-register-resource.pages.attendance';

    public function mount(): void
    {
        static::authorizeResourceAccess();
        //$this->date = now()->format('Y-m-d');
        //$this->children = Child::all();
    }

    public function saveAttendance(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'attendance' => 'array',
            'attendance.*' => 'boolean',
        ]);

        foreach ($data['attendance'] as $childId => $present) {
            if ($present) {
                AttendanceRegister::create([
                    'child_id' => $childId,
                    'received_date' => $data['date'],
                    'company_id' => auth()->user()->company_id, // or appropriate company id
                ]);
            }
        }

        $this->notify('success', 'Attendance recorded successfully');
    }

}
