<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreignId('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->string("street_name");
            $table->integer("building_number");
            $table->integer("floor_number");
            $table->integer("flat_number"); // Numbers Or Strings ? 
            $table->boolean("is_main"); // Main Address 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
