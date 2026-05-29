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
        Schema::create('hotel_revenues', function (Blueprint $table) {
        $table->id();
        $table->foreignId('booking_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('service_type'); 
        $table->decimal('amount', 10, 2);
        $table->date('revenue_date');
        $table->timestamps();
}); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_revenues');
    }
};
