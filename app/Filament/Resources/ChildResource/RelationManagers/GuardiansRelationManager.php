<?php

namespace App\Filament\Resources\ChildResource\RelationManagers;

use App\Models\Guardian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class GuardiansRelationManager extends RelationManager
{
    protected static string $relationship = 'guardians';

    
    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\TextInput::make('first_name'),
    //             Forms\Components\TextInput::make('surname'),
    //             Forms\Components\Select::make('relation')
    //             ->options([
    //                 'Parent' => 'Parent',
    //                 'Guardian' => 'Guardian',
    //             ]),

    //             Forms\Components\Select::make('title')
    //             ->options([
    //                 'Mr' => 'Mr',
    //                 'Ms' => 'Ms',
    //                 'Dr' => 'Dr',
    //             ]),
                
    //             Forms\Components\TextInput::make('id_number'),
    //             Forms\Components\Select::make('gender')
    //             ->options([
    //                 'male' => 'male',
    //                 'female' => 'female',
    //                 'other' => 'other',
    //             ]),

    //             Forms\Components\TextInput::make('address'),
    //             Forms\Components\TextInput::make('phone'),
    //             Forms\Components\TextInput::make('email'),
                
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            //->recordTitleAttribute('full_name')
            //->recordTitleAttribute(fn (Model $record) => $record->first_name . ' ' . $record->surname)
            //->recordTitleAttribute(Guardian::getGloballySearchableAttributes())
            ->columns([
                //Tables\Columns\TextColumn::make('child_id'),
                //Tables\Columns\TextColumn::make('guardian_id'),
                //Tables\Columns\TextColumn::make('full_name'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('surname'),
                Tables\Columns\TextColumn::make('relation'),
                Tables\Columns\TextColumn::make('phone'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                //Tables\Actions\AssociateAction::make(),
                Tables\Actions\AttachAction::make(),

            //     Tables\Actions\AttachAction::make()
            //     ->form(fn (Tables\Actions\AttachAction $action): array => [
            //     Forms\Components\Select::make('guardian_id')
            //         ->preload()
            //         ->options(fn() => \App\Models\Guardian::query()
            //             ->get()
            //             ->mapWithKeys(fn($item) => [$item->id => $item->title . ' - ' . $item->part])
            //             ->toArray()
            //         )
            // ]),
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
                //Tables\Actions\DissociateAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DissociateBulkAction::make(),
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
