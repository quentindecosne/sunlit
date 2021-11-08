<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrderInvoice;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseOrderInvoiceItem;
use \App\Http\Requests\StorePurchaseOrderInvoiceRequest;



class PurchaseOrderInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->can('list purchase orders')){
            $status = PurchaseOrderInvoice::getStatusList();
            return view('purchase_order_invoices.index', ['status' => $status]);

        }
    
        return abort(403, trans('error.unauthorized'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function getListForDatatables(Request $request)
    {
        $draw = 1;
        if ($request->has('draw'))
            $draw = $request->get('draw');

        $start = 0;
        if ($request->has('start'))
            $start = $request->get("start");

        $length = 10;
        if ($request->has('length')) {
            $length = $request->get("length");
        }

        $order_column = 'invoice_number';
        $order_dir = 'ASC';
        $order_arr = array();
        if ($request->has('order')) {
            $order_arr = $request->get('order');
            $column_arr = $request->get('columns');
            $column_index = $order_arr[0]['column'];
            $order_column = $column_arr[$column_index]['data'];
            $order_dir = $order_arr[0]['dir'];
        }


        $search = '';
        if ($request->has('search')) {
            $search_arr = $request->get('search');
            $search = $search_arr['value'];
        }

        $totalRecords = PurchaseOrderInvoice::count();
        

        $query = PurchaseOrderInvoice::query();
        $query->join('users', 'users.id', '=', 'user_id');
        $query->join('purchase_orders', 'purchase_orders.id', '=', 'purchase_order_id');

        //     if (!empty($column_arr[0]['search']['value'])){
        //         $query->where('purchase_orders.order_number', 'like', $column_arr[0]['search']['value'].'%');
        //     }
        //     if (!empty($column_arr[1]['search']['value'])){
        //         $query->where('warehouses.name', 'like', $column_arr[1]['search']['value'].'%');
        //     }
        //     if (!empty($column_arr[2]['search']['value'])){
        //         $query->where('suppliers.company', 'like', $column_arr[2]['search']['value'].'%');
        //     }
        //     if (!empty($column_arr[3]['search']['value'])){
        //         $query->where('purchase_orders.ordered_at', 'like', convertDateToMysql($column_arr[3]['search']['value']));
        //     }
        //     if (!empty($column_arr[4]['search']['value'])){
        //         $query->where('purchase_orders.due_at', 'like', convertDateToMysql($column_arr[4]['search']['value']));
        //     }
        //     if (!empty($column_arr[5]['search']['value'])){
        //         $query->where('purchase_orders.amount_inr', 'like', $column_arr[5]['search']['value'].'%');
        //     }
        //     if (!empty($column_arr[6]['search']['value']) && $column_arr[6]['search']['value'] != "all"){
        //         $query->where('purchase_orders.status', 'like', $column_arr[6]['search']['value']);
        //     }
        //     if (!empty($column_arr[7]['search']['value'])){
        //         $query->where('users.name', 'like', $column_arr[7]['search']['value'].'%');
       
        
        if ($request->has('search')){
            $search = $request->get('search')['value'];
            $query->where( function ($q) use ($search){
                $q->where('purchase_orders.order_number', 'like', $search.'%')
                    ->orWhere('purchase_orders.amount_inr', 'like', $search.'%')
                    ->orWhere('purchase_order_invoices.invoice_number', 'like', $search.'%');
            });    
        }

        $totalRecordswithFilter = $query->count();


        if ($length > 0)
            $query->skip($start)->take($length);

        $query->orderBy($order_column, $order_dir);
        $invoices = $query->get();

        $arr = array();
        foreach($invoices as $invoice)
        {           
            $arr[] = array(
                "id" => $invoice->id,
                "invoice_number" => $invoice->invoice_number,
                "order_number" => $invoice->purchase_order->order_number,
                "shipped_at" => $invoice->display_shipped_at,
                "due_at" => $invoice->display_due_at,
                "amount" => (isset($invoice->amount_inr)) ? trans('app.currency_symbol_inr')." ".$invoice->amount_inr : "",
                "status" => $invoice->display_status,
                "user" => $invoice->user->display_name
            );
        }

        $response = array(
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecordswithFilter,
            "data" => $arr,
            'error' => null
        );
        return response()->json($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseOrderInvoiceRequest $request)
    {
        $validatedData = $request->validated();

        $purchase_order = PurchaseOrder::find($request->purchase_order_id);
        $purchase_order->status = PurchaseOrder::SHIPPED;
        // $purchase_order->save();

        $invoice = new PurchaseOrderInvoice;
        $invoice->purchase_order_id = $purchase_order->id;
        $invoice->order_exchange_rate = $purchase_order->order_exchange_rate;
        $invoice->status = PurchaseOrderInvoice::SHIPPED;
        $invoice->due_at = $validatedData['due_at'];
        $invoice->invoice_number = $validatedData['invoice_number'];
        $invoice->shipped_at = $validatedData['shipped_at'];
        $invoice->tracking_number = $validatedData['tracking_number'];
        $invoice->courier = $validatedData['courier'];
        $invoice->user_id = $validatedData['user_id'];
        $invoice->save();

        $invoice_id = $invoice->id;
        $invoice_number = $invoice->invoice_number;
        

        $amount_usd = 0;
        foreach($request->products as $product_id => $quantity_shipped){
            $invoice_item = new PurchaseOrderInvoiceItem;
            $invoice_item->purchase_order_invoice_id = $invoice_id;
            $invoice_item->product_id = $product_id;
            $invoice_item->quantity_shipped = $quantity_shipped;
            $purchase_order_item = PurchaseOrderItem::where('purchase_order_id', $purchase_order->id)->where('product_id', $product_id)->first();
            $invoice_item->selling_price = $purchase_order_item->selling_price;
            $invoice_item->save();

            $amount_usd += $invoice_item->quantity_shipped * $invoice_item->selling_price;
        }

        $invoice->amount_usd = $amount_usd;
        $invoice->amount_inr = $invoice->amount_usd * $invoice->order_exchange_rate;
        $invoice->update();
        
        return response()->json(['success'=>'true','code'=>200, 'message'=> 'OK', 'redirect' => route('purchase-order-invoices.show', $invoice_number)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $invoice_number
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_number)
    {
        $user = Auth::user();
        if ($user->can('view purchase orders')){
            $po = PurchaseOrderInvoice::with('purchase_order')->where('invoice_number', '=', $invoice_number)->first();
            $purchase_order = $po->purchase_order;
            $invoice = PurchaseOrderInvoice::with(['items', 'items.product'])->where('invoice_number', '=', $invoice_number)->first();
            if ($invoice)
                return view('purchase_order_invoices.show', ['invoice' => $invoice, 'purchase_order' => $purchase_order ]);

            return back()->with('error', trans('error.resource_doesnt_exist', ['field' => 'purchase order']));
        }
        return abort(403, trans('error.unauthorized'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseOrderInvoice  $purchaseOrderInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseOrderInvoice $purchaseOrderInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseOrderInvoice  $purchaseOrderInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseOrderInvoice $purchaseOrderInvoice)
    {
        //
    }


    /**
     * Update the shipped_at and status of an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customs(Request $request, $id)
    {
        $validated = $request->validate([
            'customs_at' => 'required|date',
            'boe_number' => 'required',
        ]);
        $invoice = PurchaseOrderInvoice::find($id);
        $invoice->customs_at = $request->get('customs_at');
        $invoice->boe_number = $request->get('boe_number');
        $invoice->status = PurchaseOrderInvoice::CUSTOMS;
        $invoice->update();
        return redirect(route('purchase-order-invoices.show', $invoice->invoice_number))->with('success', 'order at customs'); 
    }

    /**
     * Update the cleared_at and status of an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cleared(Request $request, $id)
    {
        $validated = $request->validate([
            'cleared_at' => 'required|date',
            'customs_exchange_rate' => 'required',
        ]);
        $invoice = PurchaseOrderInvoice::find($id);
        $invoice->cleared_at = $request->get('cleared_at');
        $invoice->customs_exchange_rate = $request->get('customs_exchange_rate');
        $invoice->customs_duty = $invoice->amount_inr_customs * \Setting::get('purchase_order.customs_duty') / 100;
        $invoice->social_welfare_surcharge = $invoice->customs_duty * \Setting::get('purchase_order.social_welfare_surcharge') / 100;
        $invoice->igst = ($invoice->amount_inr + $invoice->customs_duty + $invoice->social_welfare_surcharge )* \Setting::get('purchase_order.igst') / 100;
        $invoice->bank_and_transport_charges = $invoice->amount_inr * \Setting::get('purchase_order.transport') / 100;
        $charges = [
            'customs_duty'=> \Setting::get('purchase_order.customs_duty'),
            'social_welfare_surcharge'=> \Setting::get('purchase_order.social_welfare_surcharge'),
            'igst'=> \Setting::get('purchase_order.igst'),
            'transport'=> \Setting::get('purchase_order.transport'),
        ];
        $invoice->charges = json_encode($charges);
        $invoice->status = PurchaseOrderInvoice::CLEARED;
        $invoice->update();
        return redirect(route('purchase-order-invoices.show', $invoice->invoice_number))->with('success', 'order cleared'); 
    }

    /**
     * Update the shipped_at and status of an order
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function received(Request $request, $id)
    {
        $invoice = PurchaseOrderInvoice::find($id);
        $invoice_number = $invoice->invoice_number;
        $invoice->received_at = $request->get('received_at');
        $invoice->status = PurchaseOrderInvoice::RECEIVED;
        $invoice->update();

        // $inventory = new Inventory();
        // $inventory->updateStock($invoice);

        return redirect(route('purchase-order-invoices.show', $invoice_number))->with('success', 'order received'); 
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseOrderInvoice  $purchaseOrderInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(PurchaseOrderInvoice $purchaseOrderInvoice)
    {
        //
    }
}
