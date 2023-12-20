<?php

namespace App\Filament\Resources\PaymentTermResource\Pages;

use App\Filament\Resources\PaymentTermResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePaymentTerm extends CreateRecord
{
    protected static string $resource = PaymentTermResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id; //auth()->company_id;

        return $data;
    }
}
