<?php

namespace App\Filament\Resources\LeaveApplicationResource\Pages;

use App\Filament\Resources\LeaveApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateLeaveApplication extends CreateRecord
{
    protected static string $resource = LeaveApplicationResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id;

        return $data;
    }
}
