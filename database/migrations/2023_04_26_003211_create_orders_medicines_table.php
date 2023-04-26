<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // This is the Pivot Table For Many To Many Relationships 
    public function up(): void
    {
        Schema::create('orders_medicines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('order_id')->unsigned();
            $table->unsignedBiginteger('medicine_id')->unsigned();
            $table->foreign('order_id')->references('id')
                ->on('orders')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')
                ->on('medicines')->onDelete('cascade');

            $table->string('type')->default('capsule');
            $table->integer('quantity')->default('1');
            $table->integer('price')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders_medicines');
    }
};
