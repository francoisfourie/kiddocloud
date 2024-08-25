<?php

namespace App\Filament\Reports;

use EightyNine\Reports\Components\Image;
use EightyNine\Reports\Components\Text;
use EightyNine\Reports\Components\VerticalSpace;
use EightyNine\Reports\Report;
use EightyNine\Reports\Components\Body;
use EightyNine\Reports\Components\Footer;
use EightyNine\Reports\Components\Header;
use Filament\Forms\Form;
use Malzariey\FilamentDaterangepickerFilter\Fields\DateRangePicker;
use Filament\Forms\Components\Select;
use App\Models\PaymentTerm;
use App\Models\Child;
use App\Models\ReceivedPayment;

class PaymentsReceivedReport extends Report
{
    public ?string $heading = "Payments Report";

    // public ?string $subHeading = "A great report";

    public function header(Header $header): Header
    {
        return $header
            ->schema([
                // ...
            ]);
    }


    public function body(Body $body): Body
    {
        return $body
        ->schema([
            Body\Layout\BodyColumn::make()
                ->schema([
                    Text::make("Received Payments")
                    ->fontXl()
                    ->fontBold()
                    ->primary(),
                Text::make("This is a list of payments received for the term")
                    ->fontSm()
                    ->secondary(),
                    Body\Table::make()
                    ->columns([
                        Body\TextColumn::make("first_name")
                        ->label("child name"),
                        Body\TextColumn::make("surname")
                        ->label("child surname"),
                        // Body\TextColumn::make("payment_term_id")
                        //     ->label("term id"),
                        Body\TextColumn::make("amount")
                            ->label("amount"),
                        Body\TextColumn::make("received_date")
                            ->label("received date")
                            ->dateTime(),
                    ])
                    ->data(
                        function (?array $filters) {
                             $paymentTermId = $filters['payment_term_id'] ?? -1;
                            return ReceivedPayment::query()
                                ->select("payment_term_id", "received_date", "amount","first_name","surname")
                                ->join('children', 'received_payments.child_id', '=', 'children.id')
                                // ->when($paymentTermId, function ($query, $paymentTermId) {
                                //     return $query->where('payment_term_id', '=', $paymentTermId);
                                // })
                                ->where('payment_term_id', '=', $paymentTermId)
                                ->take(100)
                                ->orderby('received_date','desc')
                                ->get();
                        }
                    ),
                    VerticalSpace::make(),
                        Text::make("Outstanding Payments")
                            ->fontXl()
                            ->fontBold()
                            ->primary(),
                        Text::make("This is a list of outstanding payments for the term")
                            ->fontSm()
                            ->secondary(),
                            Body\Table::make()
                            ->columns([
                                Body\TextColumn::make("first_name")
                                ->label("child name"),
                                Body\TextColumn::make("surname")
                                ->label("child surname"),
                                
                            ])
                            ->data(
                                function (?array $filters) {
                                    $paymentTermId = $filters['payment_term_id'] ?? -1;
                                    return Child::query()
                                    ->when($paymentTermId, function ($query, $paymentTermId) {
                                        // Exclude children with payments for the term
                                        $query->whereDoesntHave('receivedPayments', function ($query) use ($paymentTermId) {
                                            $query->where('payment_term_id', '=', $paymentTermId);
                                        });
                                    })
                                    ->select('children.id', 'children.first_name', 'children.surname') // Select child details
                                    ->take(100)
                                    ->when($paymentTermId == -1, function ($query, $paymentTermId) {
                                            return $query->where('children.id', '=', 'none');
                                        })
                                    ->orderBy('children.first_name', 'asc') // Order by child name (optional)
                                    ->get();
                                }
                            ),       
                ]),
        ]);
    }

    public function footer(Footer $footer): Footer
    {
        return $footer
            ->schema([
                // ...
            ]);
    }

    public function filterForm(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('payment_term_id')
                ->label('Payment Term')
                    ->placeholder('Choose Term')
                    ->options(PaymentTerm::all()->pluck('name', 'id'))
            ]);

    }
}
