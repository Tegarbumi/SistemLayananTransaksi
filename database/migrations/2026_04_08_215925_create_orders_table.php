<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('alat_id')->constrained('alats')->cascadeOnDelete();
    $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('payment_id')->constrained('payments')->cascadeOnDelete();
    $table->integer('durasi');
    $table->dateTime('starts');
    $table->dateTime('ends');
    $table->integer('harga');
    $table->integer('status')->default(0);
    $table->boolean('is_bonus')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
