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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الحملة
            $table->text('description'); // وصف الحملة
            $table->string('image')->nullable(); // صورة الحملة
            $table->enum('status', ['نشطة', 'مكتملة', 'قادمة'])->default('نشطة'); // حالة الحملة
            $table->unsignedBigInteger('company_id'); // معرف الشركة أو الفريق التطوعي
            $table->decimal('goal_amount', 12, 2)->default(0); // المبلغ المستهدف بالليرة السورية
            $table->decimal('current_amount', 12, 2)->default(0); // المبلغ الحالي
            $table->date('start_date'); // تاريخ بدء الحملة
            $table->date('end_date'); // تاريخ انتهاء الحملة
            $table->unsignedBigInteger('location_id')->nullable(); // معرف الموقع
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
