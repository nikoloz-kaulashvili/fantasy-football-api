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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('player_id')
                ->constrained()
                ->cascadeOnDelete()
                ->index();

            $table->foreignId('seller_team_id')
                ->constrained('teams')
                ->cascadeOnDelete();

            $table->foreignId('buyer_team_id')
                ->constrained('teams')
                ->cascadeOnDelete();

            $table->foreignId('transfer_listing_id')
                ->nullable()
                ->constrained('transfer_listings')
                ->nullOnDelete();

            $table->unsignedBigInteger('price');

            $table->unsignedBigInteger('market_value_before');
            $table->unsignedBigInteger('market_value_after');

            $table->timestamps();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
