<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\AttendanceRegister;
use Illuminate\Http\Request;
use App\Models\Child;

class Attendance extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Custom Page'; // Set a label
    protected static ?string $slug = 'custom-page'; // Set a slug

    protected static string $view = 'filament.pages.attendance';

    public function mount(): void
    {
        //static::authorizeResourceAccess();
        $this->date = now()->format('Y-m-d');
        $this->children = Child::all();
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
