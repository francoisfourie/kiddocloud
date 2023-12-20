<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnpaidChildrenResource\Pages;
use App\Filament\Resources\UnpaidChildrenResource\RelationManagers;
use App\Models\Child;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class UnpaidChildrenResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $title = 'Unpaid Children';

    // protected static function getFilters(): array
    // {
    //     return [
    //         Filters\BelongsToRelation::make('payment_term_id')->relationship('paymentTerm'),
    //         Filters\HasNoRelation::make('receivedPayments')->relationship('receivedPayments'),
    //     ];
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListUnpaidChildrens::route('/'),
            'create' => Pages\CreateUnpaidChildren::route('/create'),
            'edit' => Pages\EditUnpaidChildren::route('/{record}/edit'),
        ];
    }
}
