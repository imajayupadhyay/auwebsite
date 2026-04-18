<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->string('slug', 160)->unique();
            $table->string('title', 200);
            $table->string('subtitle', 255)->nullable();
            $table->string('icon', 120)->nullable();
            $table->string('dot_color', 9)->nullable();
            $table->string('level', 32)->default('Beginner');
            $table->string('language', 40)->default('English');
            $table->unsignedInteger('hours')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('original_price')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->unsignedInteger('students')->default(0);
            $table->boolean('available')->default(false);
            $table->string('last_updated_text', 40)->nullable();
            $table->text('description')->nullable();
            $table->json('tags')->nullable();
            $table->json('outcomes')->nullable();
            $table->json('requirements')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
