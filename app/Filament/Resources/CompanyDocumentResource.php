<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyDocumentResource\Pages;
use App\Filament\Resources\CompanyDocumentResource\RelationManagers;
use App\Models\CompanyDocument;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Grouping\Group;

class CompanyDocumentResource extends Resource
{
    protected static ?string $model = CompanyDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Admin';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                ->options([
                    'Signed Business Plan' => 'Signed Business Plan',
                    'Staff Composition' => 'Staff Composition',
                                        
                    'Other' => 'Other'

                ]),
               
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('notes'),

                FileUpload::make('path')
                ->disk('companyDocuments')
                ->directory(Auth::user()->company_id)
                ->deletable(false),
              
                ]);
           
    }

    public static function table(Table $table): Table
    {
          
        return $table
            ->columns([
               // TextColumn::make('path')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('type')->sortable(),
                Tables\Columns\TextColumn::make('description'),
               // Tables\Columns\TextColumn::make('path')
               // ->label('File')
                //->downloadLink(fn ($record) => url('/companyDocuments/' . $record->id . '/download'))
               // ->openable(fn ($record) => url('/companyDocuments/' . $record->id . '/open'))
            ])
            ->filters([
                //
            ])
             ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('open')
                ->url(fn (CompanyDocument $record): string => route('companyDocuments.open', $record->id))
                ->openUrlInNewTab()
            ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            //     function (CompanyDocument $record) {
            //         $actions = new Tables\Actions\ActionGroup([]);
            
            //         if ($record->path) {
            //             $actions->add(
            //                 Tables\Actions\Action::make('open')
            //                     ->url(fn () => route('companyDocuments.open', $record->id))
            //                     ->openUrlInNewTab()
            //             );
            //         }
            
            //         return $actions;
            //     },
            // ])
              
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->groups([
                Group::make('type')
                ->collapsible()
                ->titlePrefixedWithLabel(false)
            ])
            ->defaultGroup('type');
           // ->titlePrefixedWithLabel(false);
            //->defaultGroup('type');
    }

    protected function getActionsForRecord(CompanyDocument $record): Tables\Actions\ActionGroup
    {
      $actions = new Tables\Actions\ActionGroup([
        Tables\Actions\EditAction::make(),
      ]);
    
    //   if ($record->path) {
    //     $actions->add(
    //       Tables\Actions\Action::make('open')
    //         ->url(fn () => route('companyDocuments.open', $record->id))
    //         ->openUrlInNewTab()
    //     );
    //   }
    
      return $actions;
    }

   
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyDocuments::route('/'),
            'create' => Pages\CreateCompanyDocument::route('/create'),
            'edit' => Pages\EditCompanyDocument::route('/{record}/edit'),
        ];
    }
}
