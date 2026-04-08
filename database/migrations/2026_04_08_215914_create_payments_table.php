<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->string('no_invoice');
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->integer('total');
    $table->string('bukti')->nullable();
    $table->string('bukti_denda')->nullable();
    $table->string('jaminan_ktp')->nullable();
    $table->integer('status')->default(0);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
