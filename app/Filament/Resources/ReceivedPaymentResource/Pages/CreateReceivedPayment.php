<?php

namespace App\Filament\Resources\ReceivedPaymentResource\Pages;

use App\Filament\Resources\ReceivedPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReceivedPayment extends CreateRecord
{
    protected static string $resource = ReceivedPaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id; //auth()->company_id;

        return $data;
    }

}
