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
        Schema::create('contact_infs', function (Blueprint $table) {
            $table->id();
            $table->string("whatsappNumber");
            $table->string("phoneNumber1");
            $table->string("phoneNumber2");
            $table->string("email");
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_infs');
    }
};
