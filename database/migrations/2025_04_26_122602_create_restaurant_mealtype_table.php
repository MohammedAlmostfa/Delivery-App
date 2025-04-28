<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurant_mealtype', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_type_id')->constrained('meal_types')->cascadeOnDelete();


            $table->foreignId('restaurant_id')->constrained('restaurants')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_mealtype');
    }
};
