<?php

use App\Constants\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('name', 50)->unique();
            $table->string('logo');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('currency');
            $table->integer('payment_expiration');
            $table->timestamp('enabled_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('type', Constants::MICROSITE_TYPES);
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
