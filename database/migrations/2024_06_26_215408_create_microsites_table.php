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
        Schema::create('microsites', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40)->unique();
            $table->string('logo');
            $table->string('category');
            $table->string('currency');
            $table->integer('expiration_time');
            $table->timestamp('enabled_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('type', ['invoice', 'subscription', 'donation']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microsites');
    }
};
