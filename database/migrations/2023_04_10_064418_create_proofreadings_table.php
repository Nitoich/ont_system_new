<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProofreadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proofreadings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('discipline_id')->nullable();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete('set null');

            $table
                ->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->cascadeOnDelete('set null');

            $table
                ->foreign('discipline_id')
                ->references('id')
                ->on('disciplines')
                ->cascadeOnDelete('set null');

            $table->integer('hours');

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
        Schema::dropIfExists('proofreadings');
    }
}
