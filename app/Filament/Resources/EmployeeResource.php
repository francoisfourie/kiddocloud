<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\EmployeeType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Page;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('surname')->required(),
                Forms\Components\TextInput::make('phone')->required(),
                Forms\Components\TextInput::make('email'),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\DatePicker::make('dob')->label('Date of Birth'),
                Forms\Components\TextInput::make('emergency_contact_name')->required(),
                Forms\Components\TextInput::make('emergency_contact_phone')->required(),
                //Forms\Components\Select::make('employee_type_id')->relationship(name: 'employee_type', titleAttribute: 'descr'),
                Forms\Components\Select::make('employee_type_id')->label('Employee Type')
                ->options(EmployeeType::all()->pluck('descr', 'id'))->required(), //->relationship(name: 'employee_type', titleAttribute: 'descr')
                
                Forms\Components\TextInput::make('annual_leave_taken')
                        ->disabled()
                        ->hidden(fn (string $operation): bool => $operation === 'create') //hide on create record
                        ->dehydrated(false),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('surname')->sortable(),
                Tables\Columns\TextColumn::make('phone'),
                //Tables\Columns\TextColumn::make('company.name')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
