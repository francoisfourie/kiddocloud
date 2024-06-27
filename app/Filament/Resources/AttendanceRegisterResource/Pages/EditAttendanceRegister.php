<?php

namespace App\Filament\Resources\AttendanceRegisterResource\Pages;

use App\Filament\Resources\AttendanceRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAttendanceRegister extends EditRecord
{
    protected static string $resource = AttendanceRegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
