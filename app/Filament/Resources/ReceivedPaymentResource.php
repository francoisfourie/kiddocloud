<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReceivedPaymentResource\Pages;
use App\Filament\Resources\ReceivedPaymentResource\RelationManagers;
use App\Models\ReceivedPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Child;
use App\Models\PaymentTerm;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;

class ReceivedPaymentResource extends Resource
{
    protected static ?string $model = ReceivedPayment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Payments';
    public static $title = 'Payments Received';
    protected static ?string $navigationLabel = 'Received';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('received_date')->required()
                ->default(now()), // Set the default value to the current datetime,

                Forms\Components\Select::make('child_id')->label('Child')->required()
                ->options(Child::all()->pluck('full_name', 'id'))
                ->searchable()
                ->live()->required(), 
                
                 Forms\Components\Select::make('payment_term_id')->label('Payment Term')->required()
                 ->options(PaymentTerm::all()->pluck('name', 'id')), 
                // Forms\Components\Select::make('payment_term_id')
                // ->relationship(name: 'payment_terms', titleAttribute: 'name'),

                Forms\Components\Select::make('method')
                ->options([
                    'eft' => 'eft',
                    'card' => 'card',
                    'cash' => 'cash',
                    'other' => 'other',
                ])->required(),
               
                Forms\Components\TextInput::make('amount')
                ->numeric()->required(),
                Forms\Components\TextInput::make('reference'),
                Forms\Components\TextInput::make('note')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('received_date')->sortable()->default('received_date', 'desc'),
                Tables\Columns\TextColumn::make('paymentTerm.name')->sortable(),
                Tables\Columns\TextColumn::make('amount')->sortable(),
                Tables\Columns\TextColumn::make('child.first_name')->label('Child Name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('child.surname')->label('Child Surname')->sortable(),

            ])
            ->filters([
                Filter::make('received_date')
                ->form([
                    DatePicker::make('received_date_from'),
                    DatePicker::make('received_date_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['received_date_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('received_date', '>=', $date),
                        )
                        ->when(
                            $data['received_date_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('received_date', '<=', $date),
                        );
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReceivedPayments::route('/'),
            'create' => Pages\CreateReceivedPayment::route('/create'),
            'edit' => Pages\EditReceivedPayment::route('/{record}/edit'),
        ];
    }
}
