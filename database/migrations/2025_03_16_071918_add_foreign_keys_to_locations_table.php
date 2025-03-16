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
        Schema::table('locations', function (Blueprint $table) {
            // نتحقق أولا من وجود الجداول قبل إضافة المفاتيح الأجنبية
            if (Schema::hasTable('cities')) {
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            }
            
            if (Schema::hasTable('ads')) {
                $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');
            }
            
            if (Schema::hasTable('organizations')) {
                $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('locations', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['ad_id']);
            $table->dropForeign(['organization_id']);
        });
    }
};
