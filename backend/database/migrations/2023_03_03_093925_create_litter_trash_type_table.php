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
        Schema::create('litter_trash_type', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('litter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('trash_type_id')->constrained()->cascadeOnDelete();
            $table->unique(['litter_id', 'trash_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litter_trash_type');
    }
};
