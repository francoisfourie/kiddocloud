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
use App\Models\ReceivedPayment;

class PaymentsOutstandingReport extends Report
{
    public ?string $heading = "Report";

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
                    Body\Table::make()
                    ->columns([
                        Body\TextColumn::make("payment_term_id")
                            ->label("term id"),
                        Body\TextColumn::make("amount")
                            ->label("amount"),
                        Body\TextColumn::make("received_date")
                            ->label("received date")
                            ->dateTime(),
                    ])
                    ->data(
                        function (?array $filters) {
                             $paymentTermId = $filters['payment_term_id'] ?? null;
                            return ReceivedPayment::query()
                                // ->when($from, function ($query, $date) {
                                //     return $query->whereDate('created_at', '>=', $date);
                                // })
                                 ->when($paymentTermId, function ($query, $paymentTermId) {
                                     return $query->where('payment_term_id', '=', $paymentTermId);
                                 })
                                ->select("payment_term_id", "received_date", "amount")
                                ->take(10)
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
                    ->placeholder('Payment Term')
                    ->options(PaymentTerm::all()->pluck('name', 'id'))
            ]);

    }
}
