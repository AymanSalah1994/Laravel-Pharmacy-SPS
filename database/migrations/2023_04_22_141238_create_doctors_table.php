<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string("national_id");
            $table->string("avatar_image");
            $table->foreignId('pharmacy_id')->references('id')->on('pharmacies')->onDelete('cascade')->default(1);
          //  $table->integer("pharmacy_id")->default(1) ; 
            $table->boolean('is_banned')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
