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
        Schema::create('litters', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('cleaner_id')->nullable()->references('id')->on('users');
            $table->boolean('is_cleaned')->default(false);
            $table->integer('size');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('image_path')->nullable();
            $table->string('cleaned_image_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_accessible_by_car')->default(false);
            $table->boolean('is_located_in_hole')->default(false);
            $table->boolean('is_under_water')->default(false);
            $table->boolean('is_on_the_waterside')->default(false);
            $table->boolean('is_hard_to_reach')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litters');
    }
};
