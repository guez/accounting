<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('merchantId');

            $table->date('date')->useCurrent();
            $table->mediumText('description')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE', 'ERROR'])->default('ACTIVE');

            $table->foreign('merchantId')->references('id')->on('enterprises')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounting_entries');
    }
}
