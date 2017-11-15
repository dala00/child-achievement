<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->date('action_date');
            $table->string('action', 16);
            $table->boolean('enabled');
            $table->timestamps();

            $table->unique(['user_id', 'action_date', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('child_achievements');
    }
}
