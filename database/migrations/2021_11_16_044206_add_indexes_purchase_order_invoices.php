<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesPurchaseOrderInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_order_invoices', function (Blueprint $table) {
            $table->index('invoice_number');
            $table->index('due_at');
            $table->index('amount_inr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_order_invoices', function (Blueprint $table) {
            $table->dropIndex('purchase_order_invoices_invoice_number_index');
            $table->dropIndex('purchase_order_invoices_due_at_index');
            $table->dropIndex('purchase_order_invoices_amount_inr_index');

        });
    }
}
