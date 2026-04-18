<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('service', 120);
            $table->string('name', 120);
            $table->string('email', 160);
            $table->string('phone', 40)->nullable();
            $table->string('company', 160)->nullable();
            $table->string('budget', 80)->nullable();
            $table->string('timeline', 80)->nullable();
            $table->text('details');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_inquiries');
    }
};
