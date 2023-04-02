<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingEntryDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('accounting_entry_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('merchantId');
            $table->unsignedBigInteger('entryId');
            $table->unsignedBigInteger('accountId');

            $table->double("debit", 5, 2)->default(0);
            $table->double("credit", 5, 2)->default(0);

            $table->foreign('merchantId')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('entryId')->references('id')->on('accounting_entries')->onDelete('cascade');
            $table->foreign('accountId')->references('id')->on('accounting_accounts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounting_entry_details');
    }
}
