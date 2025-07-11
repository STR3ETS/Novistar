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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('contact_information');
            $table->string('property_name');
            $table->string('location');
            $table->text('description');
            $table->json('amenities')->nullable();
            $table->decimal('price_per_night', 8, 2);
            $table->decimal('cleaning_fee', 8, 2);
            $table->decimal('security_deposit', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
