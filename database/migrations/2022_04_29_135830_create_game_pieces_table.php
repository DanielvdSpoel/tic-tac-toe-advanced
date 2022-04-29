<?php

use App\Models\GamePosition;
use App\Models\Player;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_pieces', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('value');
            $table->boolean('deleted')->default(false);
            $table->foreignIdFor(Player::class);
            $table->foreignIdFor(GamePosition::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_pieces');
    }
};
