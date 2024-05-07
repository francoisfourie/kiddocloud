<?php

namespace App\Filament\Resources\CompanyDocumentResource\Pages;

use App\Filament\Resources\CompanyDocumentResource;
use App\Models\Company;
use App\Models\CompanyDocument;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
            //Actions\DeleteAction::make(),
            Actions\DeleteAction::make()
            ->after(function (CompanyDocument $record) {
                // delete single
                if ($record->path) {
                  //dd($record);
                  //$fullpath = $record->company_id + "/" + $record->path; 
                  Storage::disk('companyDocuments')->delete($record->path);
                }
                // delete multiple
                // if ($record->galery) {
                //   foreach ($record->galery as $ph) Storage::disk('public')->delete($ph);
                // }
            }),
          ];
        
          if ($this->record->path) {
            $actions[] = Actions\Action::make('open')
              ->url(fn () => route('companyDocuments.open', $this->record->id))
              ->openUrlInNewTab();
          }
        
          return $actions;

    }

}
