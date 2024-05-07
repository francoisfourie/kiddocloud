<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnpaidChildrenResource\Pages;
use App\Filament\Resources\UnpaidChildrenResource\RelationManagers;
use App\Models\Child;
use App\Models\PaymentTerm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use App\Models\ClassGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\EloquentBuilder;
use Illuminate\Http\Request;
use Filament\Facades\Filament;
use App\Filament\Tables\Filter\TermsNoOpFilter;

class UnpaidChildrenResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static $title = 'Unpaid Children';
    protected static ?string $navigationLabel = 'Unpaid Children';

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
                Tables\Columns\TextColumn::make('first_name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('surname')->sortable(),
                Tables\Columns\TextColumn::make('classGroups.name')->sortable(),
            ])
            ->filters([
                // SelectFilter::make('classGroups.name')
                // ->options(ClassGroup::all()->pluck('name', 'id'))

                 SelectFilter::make('payment_term_id')
                 ->options(PaymentTerm::all()->pluck('name', 'id')),
                 //TermsNoOpFilter::make('payment_term_id'),
                // Forms\Components\Select::make('payment_term_id')->label('Payment Term')
                //  ->options(PaymentTerm::all()->pluck('name', 'id')), 

            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
               // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    // public function getEloquentQuery(Request $request)
    // {
    //     // Access request parameters using $request
    //     $parameterValue = $request->input('parameter_name');

    //     // Your custom logic using the request parameters
    //     // ...

    //     // Return the Eloquent query
    //     return parent::getEloquentQuery($request);
    // }

    // public static function getEloquentQuery(Request $request)
    // {
    //     return parent::getEloquentQuery()->where(...); // Call the parent method
    // }

    // public static function applyFilters(EloquentBuilder $query): EloquentBuilder
    // {
    //     if ($searchTerm = Filament::support()->request()->query('search')) {
    //         $query->where('name', 'like', '%' . $searchTerm . '%');
    //     }

    //     if ($status = Filament::support()->request()->query('status')) {
    //         $query->where('status', $status);
    //     }

    //     return $query;
    // }

    public static function getEloquentQuery(): Builder
    {
      //  $request->route()->parameter('name');
        //return parent::getEloquentQuery()->where('gender', 'female');
        //$searchTerm = Filament::support()->request()->query('search');
        //$searchTerm = Filament::support()->request()->query('term');
       // $filament = Filament::getInstance();
       // $searchTerm = $filament->support()->request()->query('search');

        //echo $searchTerm;
        // $term = request('term');
        // echo $term;
        
        //$filterValue = request()->input('payment_term_id');
        //tableFilters[payment_term_id][value]=2ab846ed-5e30-48bd-b45c-bea568554cd7
        $termId = request()->input('tableFilters.payment_term_id.value');
        echo $termId;
        return parent::getEloquentQuery()
            ->select('children.*')
            ->leftJoin('received_payments', function($q) {
                $termId = request()->input('tableFilters.payment_term_id.value');
                $q->on('children.id', '=', 'received_payments.child_id')
                   ->where('payment_term_id', '=', $termId); //second join condition
            }) 
            //->leftJoin('received_payments', 'children.id', '=', 'received_payments.child_id')
            //->whereColumn('payment_term_id','=',$termId)
            ->whereNull('received_payments.id');

               // ->where('children.company_id', '=', auth()->user()->company_id);                
                
                


        // select * from children 
        // left join received_payments
        // ON children.id = received_payments.child_id
        // where received_payments.id IS NULL

        // return parent::getEloquentQuery()->whereNOTIn('id', function($query){
        //     $query->select('child_id')->from('received_payments')->where('company_id',auth()->user()->company_id);
        //     });

        // $users = DB::table("users")->select('*')
        // ->whereNOTIn('id',function($query){
        // $query->select('user_id')->from('invite_users');
        // })
    }

//     public static function applyFilters(EloquentBuilder $query): EloquentBuilder
// {
//     if ($searchTerm = Filament::support()->request()->query('search')) {
//         $query->where('name', 'like', '%' . $searchTerm . '%');
//     }

//     if ($status = Filament::support()->request()->query('status')) {
//         $query->where('status', $status);
//     }

//     return $query;
// }


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
