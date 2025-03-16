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
        // تجاوز إنشاء الجدول إذا كان موجودًا
        if (!Schema::hasTable('locations')) {
            Schema::create('locations', function (Blueprint $table) {
                $table->id();
                $table->decimal('latitude', 10, 8);
                $table->decimal('longitude', 11, 8);
                $table->unsignedBigInteger('city_id')->nullable();
                $table->unsignedBigInteger('ad_id')->nullable();
                $table->unsignedBigInteger('company_id')->nullable();
                $table->unsignedBigInteger('organization_id')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
