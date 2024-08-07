<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildResource\Pages;
use App\Filament\Resources\ChildResource\RelationManagers;
use App\Models\Child;
use App\Models\ClassGroup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Children';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('surname'),
                Forms\Components\DatePicker::make('date_of_birth'),
                Forms\Components\TextInput::make('id_number'),
                Forms\Components\Select::make('gender')
                ->options([
                    'male' => 'male',
                    'female' => 'female',
                    'other' => 'other',
                ]),
                Forms\Components\Select::make('home_language')
                ->options([
                    'English' => 'English',
                    'Afrikaans' => 'Afrikaans',
                    'Zulu' => 'Zulu',
                    'Xhosa' => 'Xhosa',
                    'Sepedi' => 'Sepedi',
                    'Tswana' => 'Tswana',
                    'Southern Sotho' => 'Southern Sotho',
                    'Tsonga' => 'Tsonga',
                    'Swazi' => 'Swazi',
                    'Venda' => 'Venda',
                    'Southern Ndebele' => 'Southern Ndebele',
                ]),
                Forms\Components\TextInput::make('medical_condition'),
                Forms\Components\TextInput::make('allergies'),
                Forms\Components\Select::make('class_group_id')->label('Class Group')
                ->options(ClassGroup::all()->pluck('name', 'id')), //->relationship(name: 'employee_type', titleAttribute: 'descr')
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'surname'])
                    ->sortable()
                    ->getStateUsing(function (Child $record): string {
                        return $record->first_name . ' ' . $record->surname;
                    }),
                Tables\Columns\TextColumn::make('classGroups.name')->sortable(),
            ])
            ->filters([
                SelectFilter::make('classGroups.name')
                ->options(ClassGroup::all()->pluck('name', 'id'))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
               // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
         return [
             RelationManagers\GuardiansRelationManager::class,
         ];
        // return [
        //     RelationManager::make('guardians')
        //         ->label('Guardians')
        //         ->columns([
        //             TextColumn::make('full_name')
        //                 ->recordTitleAttribute('full_name')
        //                 ->label('Full Name'),
        //         ]),
        // ];
        
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
        ];
    }
}
