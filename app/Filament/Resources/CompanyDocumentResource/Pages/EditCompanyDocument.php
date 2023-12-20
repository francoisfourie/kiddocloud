<?php

namespace App\Filament\Resources\CompanyDocumentResource\Pages;

use App\Filament\Resources\CompanyDocumentResource;
use App\Models\Company;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\Request;

class EditCompanyDocument extends EditRecord
{
    protected static string $resource = CompanyDocumentResource::class;

    protected function getHeaderActions(): array
    {
        // return [
        //     Actions\DeleteAction::make(),
        //     // Actions\Action::make('open')
        //     //      ->url(fn (): string => route('companyDocuments.open', $this->record->id))
        //     //      ->openUrlInNewTab(),
        // ];

        $actions = [
            Actions\DeleteAction::make(),
          ];
        
          if ($this->record->path) {
            $actions[] = Actions\Action::make('open')
              ->url(fn () => route('companyDocuments.open', $this->record->id))
              ->openUrlInNewTab();
          }
        
          return $actions;

    }

}
