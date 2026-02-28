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
        Schema::create('players', function (Blueprint $table) {
            $table->id();

            $table->foreignId('team_id')
                ->index()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('country');

            $table->unsignedTinyInteger('age');

            $table->enum('position', ['GK', 'DF', 'MF', 'FW'])->index();

            $table->unsignedBigInteger('market_value')
                ->default(1000000 * 100);

            $table->enum('squad_role', ['starter', 'bench'])
                ->default('bench')
                ->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
