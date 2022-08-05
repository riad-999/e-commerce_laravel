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
            $table->string('state')->index();
            $table->string('address');
            $table->string('wilaya')->index();
            $table->string('shipment_type');
            $table->unsignedInteger('shipment');
            $table->string('number');
            $table->string('name')->index();
            $table->text('note')->nullable();
            $table->string('email');
            $table->string('track_code')->nullable();
            $table->timestamp('created_at')->index();
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