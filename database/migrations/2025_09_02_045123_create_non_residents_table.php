<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('non_residents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_num');
            $table->string('plate_num')->unique();
            $table->integer('days');
            $table->timestamp('entry_time')->nullable();
            $table->string('status')->default('New');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('non_residents');
    }
};
