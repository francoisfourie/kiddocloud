<?php

namespace App\Filament\Resources\PaymentTermResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Illuminate\Support\Facades\Response;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Child;

class ReceivedPaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'receivedPayments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('child.full_name'),
                Tables\Columns\TextColumn::make('received_date')->date("d/m/Y")->sortable(),
                Tables\Columns\TextColumn::make('amount'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                //Tables\Actions\ViewMissingRecords::make(),
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
               //Tables\Actions\DeleteAction::make(),
            //    Tables\Actions\Action::make('modal')
            //         ->icon('heroicon-m-pencil-square')
            //         ->iconButton()
            //         //->action(fn (StatementTransaction $transaction) => Log::debug($transaction))
            //         ->modalContent(fn (StatementTransaction $transaction): View => view('livewire.components.statements.edit-statement-transaction', ['transaction' => $transaction]))

                // Tables\Actions\CreateAction::make()
                // ->modal(function (Tables\Modal\Actions $modal) {
                //     return $modal->schema([
                //         // Here you can define the fields if you want to use Filament forms
                //         // Or you can simply render a Livewire component like this:
                //         $this->livewire(\App\Livewire\UnpaidChildrenList::class),
                //     ]);
                // }),

                // Tables\Actions\Action::make('modal')
                // //->action(fn (Post $record) => $record->advance())
                // ->modalContent(view('Livewire.UnpaidChildrenList'))

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public function actionViewMissingRecords(): ActionResult
    // {
    //     $currentResourceId = $this->getRecord()->getKey();

    //     // Fetch missing records
    //     $missingRecords = Child::whereNotIn('id', function (Builder $subquery) use ($currentResourceId) {
    //         $subquery->select('related_record_id')
    //             ->from('related_records')
    //             ->where('record_id', $currentResourceId);
    //     })->get();

    //     // Display missing records in a modal or separate page
    //     return $this->modal(compact('missingRecords'));
    // }

}
