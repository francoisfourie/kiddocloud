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
use Illuminate\Support\Facades\DB;

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
            ->query(
                AttendanceRegister::query()
                    ->select('received_date', 'class_group_id')
                    ->selectRaw('COUNT(*) as total_children')
                    ->selectRaw('SUM(CASE WHEN present = 1 THEN 1 ELSE 0 END) as present_children')
                    ->selectRaw("CONCAT(received_date, '-', class_group_id) as id")
                    ->groupBy('received_date', 'class_group_id')
            )
            ->defaultSort('received_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('received_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classGroup.name')
                    ->label('Class Group')
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->join('class_groups', 'attendance_registers.class_group_id', '=', 'class_groups.id')
                            ->orderBy('class_groups.name', $direction)
                            ->select('attendance_registers.*');
                    }),
                Tables\Columns\TextColumn::make('total_children')
                    ->label('Total Children')
                    ->sortable(),
                Tables\Columns\TextColumn::make('present_children')
                    ->label('Present Children')
                    ->sortable(),
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
                Tables\Actions\Action::make('view_details')
                    ->label('View/Edit')
                    ->url(fn ($record): string => Attendance::getUrl(['received_date' => $record->received_date, 'class_group_id' => $record->class_group_id])),
            ]);
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     return AttendanceRegister::whereDate('received_date', today())->count();
    // }
}