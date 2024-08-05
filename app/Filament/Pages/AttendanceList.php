<?php

namespace App\Filament\Pages;

use App\Models\AttendanceRegister;
use App\Models\ClassGroup;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;

class AttendanceList extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Attendance List';
    protected static ?string $navigationGroup = 'Attendance Management';
    protected static ?string $slug = 'attendance-list';
    protected static string $view = 'filament.pages.attendance-list';

    public function table(Table $table): Table
    {
        return $table
            ->query(AttendanceRegister::query())
            ->columns([
                Tables\Columns\TextColumn::make('received_date')
                    ->label('Date')
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
                    ->label('Class Group')
                    ->options(ClassGroup::pluck('name', 'id')),
                Tables\Filters\Filter::make('received_date')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('received_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('received_date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn (AttendanceRegister $record): string => Attendance::getUrl(['received_date' => $record->received_date, 'class_group_id' => $record->class_group_id])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return AttendanceRegister::whereDate('received_date', today())->count();
    }
}