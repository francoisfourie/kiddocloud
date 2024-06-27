<?php

namespace App\Filament\Resources\AttendanceRegisterResource\Pages;

use App\Filament\Resources\AttendanceRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAttendanceRegisters extends ListRecords
{
    protected static string $resource = AttendanceRegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
