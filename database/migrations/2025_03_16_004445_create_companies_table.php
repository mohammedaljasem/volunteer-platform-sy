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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الشركة أو الفريق التطوعي
            $table->text('description')->nullable(); // وصف الشركة
            $table->boolean('verified')->default(false); // تم التحقق منها؟
            $table->unsignedBigInteger('location_id')->nullable(); // معرف الموقع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
