<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeaveApplicationResource\Pages;
use App\Filament\Resources\LeaveApplicationResource\RelationManagers;
use App\Models\LeaveApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class LeaveApplicationResource extends Resource
{
    protected static ?string $model = LeaveApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\Select::make('employee_id')->label('Employee')
                ->options(Employee::all()->pluck('name', 'id')), //->relationship(name: 'employee_type', titleAttribute: 'descr')
                Forms\Components\Select::make('leave_type')
                ->options([
                    'annual leave' => 'annual leave',
                    'sick leave' => 'sick leave',
                    'family responsibility' => 'family responsibility',
                    'unpaid' => 'unpaid',
                    'maternity leave' => 'maternity leave',
                    'other' => 'other',
                ]),

                Forms\Components\Select::make('status')
                ->options([
                    'applied' => 'applied',
                    'approved' => 'approved',
                    'declined' => 'declined',
                ]),
                Forms\Components\TextInput::make('remarks'),
                Forms\Components\TextInput::make('leave_days')
                ->numeric()
                ->step(0.5),
                
                Forms\Components\DatePicker::make('application_date')
                ->default(now()), // Set the default value to the current datetime,
                Forms\Components\DatePicker::make('start_date'),

               // Forms\Components\Select::make('employee_type_id')->relationship(name: 'employee_type', titleAttribute: 'descr')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               // Tables\Columns\TextColumn::make('employee.full_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('employee.name')->label('Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('employee.surname')->label('Surname')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('leave_type')->sortable(),
                Tables\Columns\TextColumn::make('start_date')->date("d/m/Y")->sortable(),
                Tables\Columns\TextColumn::make('leave_days')->sortable(),
                Tables\Columns\TextColumn::make('leave_days')->summarize(Sum::make()->label('total'))
            ])
            ->filters([
                //
                Filter::make('start_date')
                    ->form([
                        DatePicker::make('start_date_from'),
                        DatePicker::make('start_date_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['start_date_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '<=', $date),
                            );
                    }),

                SelectFilter::make('leave_type')
                    ->options([
                        'annual leave' => 'annual leave',
                        'sick leave' => 'sick leave',
                        'family responsibility' => 'family responsibility',
                        'unpaid' => 'unpaid',
                        'maternity leave' => 'maternity leave',
                        'other' => 'other',
                    ])

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLeaveApplications::route('/'),
            'create' => Pages\CreateLeaveApplication::route('/create'),
            'edit' => Pages\EditLeaveApplication::route('/{record}/edit'),
        ];
    }
}
