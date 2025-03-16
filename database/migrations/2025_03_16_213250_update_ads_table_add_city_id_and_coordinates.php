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
        // التحقق من وجود حقل city_id قبل إضافته
        if (!Schema::hasColumn('ads', 'city_id')) {
            Schema::table('ads', function (Blueprint $table) {
                // إضافة حقل city_id كمفتاح خارجي للمدن
                $table->unsignedBigInteger('city_id')->nullable()->after('end_date');
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            });
        }
        
        // التحقق من وجود حقول الإحداثيات قبل إضافتها
        if (!Schema::hasColumn('ads', 'latitude') && !Schema::hasColumn('ads', 'longitude')) {
            Schema::table('ads', function (Blueprint $table) {
                // إضافة حقول الإحداثيات
                $table->decimal('latitude', 10, 7)->nullable()->after('city_id');
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            // حذف الحقول إذا كانت موجودة
            if (Schema::hasColumn('ads', 'latitude')) {
                $table->dropColumn('latitude');
            }
            
            if (Schema::hasColumn('ads', 'longitude')) {
                $table->dropColumn('longitude');
            }
            
            if (Schema::hasColumn('ads', 'city_id')) {
                $table->dropForeign(['city_id']);
                $table->dropColumn('city_id');
            }
        });
    }
};
