<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_items', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_valid');
            $table->text('keterangan')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0. belum di validasi, 1. validasi sales, 2. validasi direktur, 3. tolak');
            $table->text('remarks_sales')->nullable();
            $table->text('remarks_direktur')->nullable();
            $table->datetime('validate_sales_at')->nullable();
            $table->datetime('validate_direktur_at')->nullable();
            $table->timestamps();


            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retur_items');
    }
}
