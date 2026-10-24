<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add flower information columns.
     */
    public function up(): void
    {
        Schema::table('flowers', function (Blueprint $table) {
            $table->string('name')->unique();
            $table->string('scientific_name')->nullable();
            $table->string('local_name')->nullable();
            $table->text('description')->nullable();
            $table->text('characteristics')->nullable();
            $table->text('colors')->nullable();
            $table->text('growing_conditions')->nullable();
            $table->text('care_guide')->nullable();
            $table->text('uses')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Remove flower information columns.
     */
    public function down(): void
    {
        Schema::table('flowers', function (Blueprint $table) {
            $table->dropUnique(['name']);

            $table->dropColumn([
                'name',
                'scientific_name',
                'local_name',
                'description',
                'characteristics',
                'colors',
                'growing_conditions',
                'care_guide',
                'uses',
                'image_path',
                'is_active',
            ]);
        });
    }
};
