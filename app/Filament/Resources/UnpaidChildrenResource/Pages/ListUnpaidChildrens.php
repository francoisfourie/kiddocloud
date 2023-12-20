<?php

namespace App\Filament\Resources\UnpaidChildrenResource\Pages;

use App\Filament\Resources\UnpaidChildrenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUnpaidChildrens extends ListRecords
{
    protected static string $resource = UnpaidChildrenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
