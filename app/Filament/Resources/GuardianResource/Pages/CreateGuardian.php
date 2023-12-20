<?php

namespace App\Filament\Resources\GuardianResource\Pages;

use App\Filament\Resources\GuardianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateGuardian extends CreateRecord
{
    protected static string $resource = GuardianResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id;

        return $data;
    }

}
