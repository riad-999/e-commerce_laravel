<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('state')->default('in process')->index();
            $table->string('address');
            $table->string('wilaya');
            $table->unsignedInteger('shipment');
            $table->unsignedInteger('total');
            $table->string('number');
            $table->string('name')->index();
            $table->string('email');
            $table->string('track_code')->nullable();
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
};