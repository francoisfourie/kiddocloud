<?php

namespace App\Filament\Resources\ReceivedPaymentResource\Pages;

use App\Filament\Resources\ReceivedPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReceivedPayment extends EditRecord
{
    protected static string $resource = ReceivedPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
