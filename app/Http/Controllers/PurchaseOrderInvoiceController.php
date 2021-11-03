<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrderInvoice;
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
        //
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
        $purchase_order->statue = PurchaseOrder::SHIPPED;

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
        $invoice_id = $invoice->save();

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
        

        return redirect(route('purchase-orders.show', $order->order_number)); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseOrderInvoice  $purchaseOrderInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseOrderInvoice $purchaseOrderInvoice)
    {
        //
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
