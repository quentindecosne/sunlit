<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DealersAddEmails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('dealers', function (Blueprint $table) {
            $table->string('email3')->after('email')->nullable();
            $table->string('email2')->after('email')->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('dealers', function (Blueprint $table) {
            $table->dropColumn('email2');
            $table->dropColumn('email3');
        });        
    }
}
