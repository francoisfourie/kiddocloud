<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuardianResource\Pages;
use App\Filament\Resources\GuardianResource\RelationManagers;
use App\Models\Guardian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')->required(),
                Forms\Components\TextInput::make('surname')->required(),
                Forms\Components\Select::make('relation')
                ->options([
                    'Parent' => 'Parent',
                    'Guardian' => 'Guardian',
                ])->required(),

                Forms\Components\Select::make('title')
                ->options([
                    'Mr' => 'Mr',
                    'Ms' => 'Ms',
                    'Dr' => 'Dr',
                ]),
                
                Forms\Components\TextInput::make('id_number'),
                Forms\Components\Select::make('gender')
                ->options([
                    'male' => 'male',
                    'female' => 'female',
                    'other' => 'other',
                ]),

                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('phone')->required(),
                Forms\Components\TextInput::make('email'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('surname')->sortable(),
                //Tables\Columns\TextColumn::make('guardian.children'),
                //Tables\Columns\TextColumn::make('children_count')->counts('children')->description(fn (Guardian $record): string => $record->childrenNames()),
                //Tables\Columns\TextColumn::make('guardian.childrenNames')->sortable(),
                //Tables\Columns\TextColumn::make('title')->description(fn (Guardian $record): string => $record->childrenNames())
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
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
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            'edit' => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }
}
