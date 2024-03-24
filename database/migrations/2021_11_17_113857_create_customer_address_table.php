<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->default(0);
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->foreignId('province_id')->default(0);
            $table->foreignId('district_id')->default(0);
            $table->foreignId('ward_id')->default(0);
            $table->string('address', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('customer_address');
    }
}
