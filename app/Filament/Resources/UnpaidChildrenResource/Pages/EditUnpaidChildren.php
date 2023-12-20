<?php

namespace App\Filament\Resources\UnpaidChildrenResource\Pages;

use App\Filament\Resources\UnpaidChildrenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnpaidChildren extends EditRecord
{
    protected static string $resource = UnpaidChildrenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
