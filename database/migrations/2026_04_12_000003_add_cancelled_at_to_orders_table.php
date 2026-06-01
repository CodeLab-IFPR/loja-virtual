<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite doesn't support ADD COLUMN with constraints on existing tables easily,
            // but nullable columns are fine.
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('cancelled_at')->nullable()->after('rejected_at');
            });
        } else {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('cancelled_at')->nullable()->after('rejected_at');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('cancelled_at');
        });
    }
};
