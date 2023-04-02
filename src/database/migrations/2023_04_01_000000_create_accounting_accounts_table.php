<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingAccountsTable extends Migration
{
  public function up()
  {
    Schema::create('accounting_accounts', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger('merchantId');
      $table->unsignedBigInteger('accountMasterId')->nullable();

      $table->string('code', 100);
      $table->string('name', 255);
      $table->string('positionCode', 50);
      $table->enum('type', ['ASSET', 'LIABILITY', 'CAPITAL', 'INCOME', 'EXPENSES'])->default('ASSET');
      $table->unsignedSmallInteger('level')->default(0);

      $table->foreign('merchantId')->references('id')->on('enterprises')->onDelete('cascade');
      $table->foreign('accountMasterId')->references('id')->on('accounting_accounts')->onDelete('set null');

      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::dropIfExists('accounting_accounts');
  }
}
