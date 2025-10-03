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
            $table->string('image')->nullable()->after('images'); // Imagem principal
            $table->decimal('weight', 8, 2)->nullable()->after('manage_stock'); // Peso em kg
            $table->string('dimensions')->nullable()->after('weight'); // Dimensões
            $table->string('material')->nullable()->after('dimensions'); // Material
            $table->string('color')->nullable()->after('material'); // Cor
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image', 'weight', 'dimensions', 'material', 'color']);
        });
    }
};
