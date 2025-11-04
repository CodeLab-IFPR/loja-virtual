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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['material', 'color']);
            $table->foreignId('material_id')->nullable()->constrained('materials')->onDelete('set null');
            $table->foreignId('color_id')->nullable()->constrained('colors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('material')->nullable()->after('dimensions'); 
            $table->string('color')->nullable()->after('material');
            $table->dropForeign(['material_id']);
            $table->dropColumn('material_id');
            $table->dropForeign(['color_id']);
            $table->dropColumn('color_id');

        });
    }
};
