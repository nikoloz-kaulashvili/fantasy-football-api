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
        Schema::create('transfer_listings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('seller_team_id')
                ->constrained('teams')
                ->cascadeOnDelete();

            $table->unsignedBigInteger('price')->index();

            $table->unsignedTinyInteger('is_active')->index()->default(1);

            $table->timestamp('sold_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_listings');
    }
};
