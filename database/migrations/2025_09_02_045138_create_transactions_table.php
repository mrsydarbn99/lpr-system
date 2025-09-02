<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('plate_num');
            $table->dateTime('time');
            $table->string('status');
            $table->string('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
