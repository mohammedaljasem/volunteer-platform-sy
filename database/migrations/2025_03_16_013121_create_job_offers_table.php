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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان فرصة التطوع
            $table->text('description'); // وصف فرصة التطوع
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['متاحة', 'مغلقة', 'قادمة'])->default('متاحة'); // حالة فرصة التطوع
            $table->unsignedBigInteger('location_id')->nullable(); // معرف الموقع
            $table->date('deadline'); // تاريخ انتهاء التقديم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
