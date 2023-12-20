<?php

namespace App\Filament\Resources\ChildResource\Pages;

use App\Filament\Resources\ChildResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateChild extends CreateRecord
{
    protected static string $resource = ChildResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id; //auth()->company_id;

        return $data;
    }

}
