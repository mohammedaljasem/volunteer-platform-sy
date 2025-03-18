<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsRecurringAndIsAutoProcessedToDonations extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'is_recurring')) {
                $table->boolean('is_recurring')->default(false)->after('date');
            }
            if (!Schema::hasColumn('donations', 'is_auto_processed')) {
                $table->boolean('is_auto_processed')->default(false)->after('is_recurring');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn('is_recurring');
            $table->dropColumn('is_auto_processed');
        });
    }
}
