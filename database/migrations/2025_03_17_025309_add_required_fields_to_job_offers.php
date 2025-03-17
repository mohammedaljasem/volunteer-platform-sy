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
        Schema::table('job_offers', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('deadline');
            $table->unsignedBigInteger('city_id')->nullable()->after('location_id');
            $table->text('requirements')->nullable()->after('description');
            
            // إضافة الفورين كي
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_offers', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn(['start_date', 'city_id', 'requirements']);
        });
    }
};
