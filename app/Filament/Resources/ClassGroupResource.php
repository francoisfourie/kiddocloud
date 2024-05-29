<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassGroupResource\Pages;
use App\Filament\Resources\ClassGroupResource\RelationManagers;
use App\Models\ClassGroup;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassGroupResource extends Resource
{
    protected static ?string $model = ClassGroup::class;
    protected static ?string $navigationGroup = 'Settings';
    public static $title = 'Classes';
    protected static ?string $navigationLabel = 'Classes';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('description')->required(),
                
                
                Forms\Components\Select::make('teacher_id')
                ->label('Teacher')
                ->options(Employee::getByType('teacher')->pluck('name', 'id')),
                //->searchable()
                Forms\Components\Select::make('assistant_id')
                ->label('Assistant')
                ->options(Employee::getByType('assistant')->pluck('name', 'id')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('teacher.name'),
                Tables\Columns\TextColumn::make('description'),
                //Tables\Columns\TextColumn::make('employee.name')->sortable(),
            ])
            ->filters([
                //
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
            RelationManagers\ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClassGroups::route('/'),
            'create' => Pages\CreateClassGroup::route('/create'),
            'edit' => Pages\EditClassGroup::route('/{record}/edit'),
        ];
    }
}
