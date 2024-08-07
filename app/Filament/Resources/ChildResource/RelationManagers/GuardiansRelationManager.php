<?php

namespace App\Filament\Resources\ChildResource\RelationManagers;

use App\Models\Guardian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class GuardiansRelationManager extends RelationManager
{
    protected static string $relationship = 'guardians';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(fn (Guardian $record): string => "{$record->first_name} {$record->surname}")
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'surname'])
                    ->sortable(query: function (Builder $query, string $direction): Builder {
                        return $query
                            ->orderBy('first_name', $direction)
                            ->orderBy('surname', $direction);
                    })
                    ->getStateUsing(fn (Guardian $record): string => "{$record->first_name} {$record->surname}"),
                Tables\Columns\TextColumn::make('relation'),
                Tables\Columns\TextColumn::make('phone'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectSearchColumns(['first_name', 'surname'])
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->options(fn () => Guardian::orderBy('first_name')
                                ->orderBy('surname')
                                ->get()
                                ->mapWithKeys(fn (Guardian $guardian) => [$guardian->id => "{$guardian->first_name} {$guardian->surname}"])
                                ->toArray())
                            ->label('Guardian'),
                    ]),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DissociateBulkAction::make(),
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->defaultSort('first_name', 'asc');
    }
}
