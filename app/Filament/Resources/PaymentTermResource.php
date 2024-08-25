<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentTermResource\Pages;
use App\Filament\Resources\PaymentTermResource\RelationManagers;
use App\Models\PaymentTerm;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Carbon\Carbon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Livewire\UnpaidChildrenList;
use Livewire\Component;
use Livewire\Livewire;
use Illuminate\View\View;

class PaymentTermResource extends Resource
{
    protected static ?string $model = PaymentTerm::class;
    protected static ?string $navigationGroup = 'Payments';
    public static $title = 'Payment Terms';
    protected static ?string $navigationLabel = 'Terms';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('start_date')->default(Carbon::now()->startOfMonth()),
                Forms\Components\DatePicker::make('end_date')->default(Carbon::now()->endOfMonth()),
                Forms\Components\TextInput::make('name')->default(Carbon::now()->format('Y-m'))
                                                        ->required()
                                                        ->unique(function (Builder $query) {
                                                            $companyId = auth()->user()->company_id; // Adjust based on your company ID retrieval logic
                                                            $query->where('company_id', $companyId);
                                                        }),
                                                       // ->unique(scope: 'company_id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('start_date')->date("d/m/Y")->sortable(),
                Tables\Columns\TextColumn::make('end_date')->date("d/m/Y")->sortable(),
            ])
            ->filters([
                //
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
            RelationManagers\ReceivedPaymentsRelationManager::class,

            // 'noPayments' => function () {
            //     $query = $this->hasMany(ReceivedPayment::class, 'payment_term_id');
            //     // $query->whereHas('child', function (Builder $query) {
            //     //     $query->whereDoesntHave('receivedPayments');
            //     // });
            //     return $query;
            // },

           // RelationManagers\ReceivedPaymentsRelationManager::class,
            // Grid::make('Unpaid Children')
            // ->schema([
            //     // Define the list schema for unpaid children
            // ])
        ];
    }

    // public function render(): View
    // {
    //     return View::make('livewire.UnpaidChildrenList');
    // }

    // public function render(): View
    // {
    //     dd();
    //     return "hallo";
    //     // return view('resources.payment-terms.view', [
    //     //     'paymentTerm' => $this,
    //     //     'unpaidChildrenList' => Livewire::component('unpaid-children-list', UnpaidChildrenList::class, ['paymentTermId' => 123]),
    //     //     //'notes' => Note::where('payment_term_id', $this->id)->get(),
    //     // ]);
    // }

    // public function render(): View
    // {
    //     return View::make('resources.payment-terms.view', [
    //         'paymentTerm' => $this,
    //         // ... existing data for the view
    //         //'unpaidChildrenList' => Livewire::component('unpaid-children-list', UnpaidChildrenList::class, ['paymentTermId' => $this->id]),
    //     ]);
    // }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentTerms::route('/'),
            'create' => Pages\CreatePaymentTerm::route('/create'),
            'edit' => Pages\EditPaymentTerm::route('/{record}/edit'),
        ];
    }



}
