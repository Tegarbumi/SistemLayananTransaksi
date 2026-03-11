<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddServiceIdToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            // tambah kolom service
            $table->unsignedBigInteger('service_id')->nullable()->after('alat_id');

        });

        // ubah alat_id supaya boleh NULL
        DB::statement('ALTER TABLE orders MODIFY alat_id BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropColumn('service_id');

        });
    }
}