<?php

namespace App\Filament\Resources\CompanyDocumentResource\Pages;

use App\Filament\Resources\CompanyDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateCompanyDocument extends CreateRecord
{
    protected static string $resource = CompanyDocumentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id; //auth()->company_id;

        return $data;
    }
}
