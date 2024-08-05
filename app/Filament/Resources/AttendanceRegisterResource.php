<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceRegisterResource\Pages;
use App\Models\AttendanceRegister;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendanceRegisterResource extends Resource
{
    protected static ?string $model = AttendanceRegister::class;
    protected static ?string $navigationGroup = 'Attendance';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('child_id')
                    ->relationship('child', 'first_name')
                    ->required(),
                Forms\Components\Select::make('class_group_id')
                    ->relationship('classGroup', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Toggle::make('present')
                    ->required(),
                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classGroup.name')
                    ->label('Class Group')
                    ->searchable(),
                Tables\Columns\TextColumn::make('child.first_name')
                    ->label('Child')
                    ->searchable(),
                Tables\Columns\IconColumn::make('present')
                    ->boolean(),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('class_group_id')
                    ->relationship('classGroup', 'name'),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
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
