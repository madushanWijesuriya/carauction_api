<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\CountryContent;
use App\Models\Page;
use App\Http\CustomFilters\DateRangeFilter;
use App\Http\CustomFilters\SearchTextFilter;
use App\Http\Resources\Customer\StockResource;
use App\Http\Resources\Customer\LedgerResource;
use App\Http\Resources\Customer\TransactionResource;
use App\Models\VehicleDoc;
use App\Models\Payment;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class FinanceController extends Controller
{
    public function getTileData(Request $request) {
        $payments = Payment::select('*')->where('customer_id', auth()->user()->id);
        $stock_count = $payments->count();
        $transaction_count = $payments->count();

        $freight_amount = 0;
        $vehicleIds = Payment::select('*')->where('customer_id', auth()->user()->id)->pluck('vehicle_id')->toArray();
        $vehicles = Vehicle::whereIn('id',$vehicleIds)->get();
        $total_sale = $freight_amount + $vehicles->sum('fob_price');
        $total_credit = $payments->sum('paid_amount');
        $total_debit = $total_sale - $total_credit;
        $total_bal = $total_credit - $total_debit;
        
        dd($total_bal);
        
    }

    public function getStockList(Request $request){
        $query = Payment::select('*')->where('customer_id', auth()->user()->id)->with('vehicle');

        $result = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('stock_search_text', new SearchTextFilter),
            ]);

        if( !$request->has('noPagination')) {
            $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
        } else {
            $result = $result->get();
        }
        return StockResource::collection($result);
    }
    
    public function getLedgerList(Request $request){
        $query = Payment::select('*')->where('customer_id', auth()->user()->id)->with('vehicle');;

        $result = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('ledger_search_text', new SearchTextFilter),
            ])
            ->allowedSorts(['id','vehicle_id','customer_id', 'agent', 'paid_amount', 'fob_price', 'created_at' ,'debit' ,'credit', 'balance']);


        if( !$request->has('noPagination')) {
            $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
        } else {
            $result = $result->get();
        }

        $data = LedgerResource::collection($result);
        $items = $data->collection;
        $table_footer = [
            'debit' => 0,  
            'credit' => 0,  
            'balance' => 0,  
        ];
        
        $freight_amount = 0;
        $vehicleIds = $items->pluck('vehicle_id')->toArray();
        $vehicles = Vehicle::whereIn('id',$vehicleIds)->get();
        $total_sale = $freight_amount + $vehicles->sum('fob_price');
        $total_credit = $items->sum('paid_amount');
        $total_debit = $total_sale - $total_credit;
        $total_bal = $total_credit - $total_debit;
        
        $table_footer['debit'] = $total_sale;
        $table_footer['credit'] = $total_credit;
        $table_footer['balance'] = $total_bal;
        
        return LedgerResource::collection($result)->additional(['footer' => $table_footer]);
    }

    public function getTransactionList(Request $request){
        $query = Payment::join('vehicles', 'payments.vehicle_id', 'vehicles.id')->select('*')->where('customer_id', auth()->user()->id)->with('vehicle');

        $result = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::custom('payment_search_text', new SearchTextFilter),
            ])
            ->allowedSorts(['id','vehicle_id','customer_id', 'agent', 'paid_amount', 'fob_price', 'remaining_amount' ,'make_at' ,'chassis_no', 'created_at']);

            if( !$request->has('noPagination')) {
                $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $result = $result->get();
            }

        return TransactionResource::collection($result);
    }

}
