<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceRegisterResource\Pages;
use App\Filament\Resources\AttendanceRegisterResource\RelationManagers;
use App\Models\AttendanceRegister;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceRegisterResource extends Resource
{
    protected static ?string $model = AttendanceRegister::class;
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Select::make('child_id')
                ->label('Child')
                ->relationship('child', 'first_name')
                ->searchable()
                ->required(),
            Forms\Components\DatePicker::make('received_date')
                ->label('Date')
                ->required(),
            Forms\Components\Textarea::make('notes')
                ->label('Notes'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('child.first_name')
                ->label('Child'),
            Tables\Columns\TextColumn::make('received_date')
                ->label('Date'),
            Tables\Columns\TextColumn::make('notes')
                ->label('Notes')
                ->limit(50),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAttendanceRegisters::route('/'),
            'create' => Pages\CreateAttendanceRegister::route('/create'),
            'edit' => Pages\EditAttendanceRegister::route('/{record}/edit'),
        ];
    }
}
