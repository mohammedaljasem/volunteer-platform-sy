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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المنظمة
            $table->text('description'); // وصف المنظمة
            $table->boolean('verified')->default(false); // حالة التحقق
            $table->string('verification_docs')->nullable(); // وثائق التحقق
            $table->unsignedBigInteger('location_id')->nullable(); // معرف الموقع
            $table->string('contact_email'); // البريد الإلكتروني للتواصل
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
