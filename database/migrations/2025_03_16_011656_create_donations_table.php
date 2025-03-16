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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 12, 2); // المبلغ بالليرة السورية
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ad_id')->constrained('ads')->onDelete('cascade');
            $table->date('date'); // تاريخ التبرع
            $table->boolean('is_recurring')->default(false); // هل التبرع متكرر
            $table->enum('payment_method', ['نقدي', 'تحويل بنكي'])->default('نقدي'); // طريقة الدفع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
