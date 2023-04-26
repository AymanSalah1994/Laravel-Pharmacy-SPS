<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade'); // For the Creator Of the Order
            $table->foreignId('customer_id')->references('id')->on('customers')->onDelete('cascade');  // For the Cutomer For Whom This Medicine 
            $table->foreignId('delivering_address_id')->references('id')->on('user_addresses')->onDelete('cascade');
            $table->boolean("is_insured");
            $table->string("status")->default("New");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
