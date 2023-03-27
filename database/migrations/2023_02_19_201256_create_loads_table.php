<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->unsignedBigInteger('discipline_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->nullOnDelete();

            $table->foreign('discipline_id')
                ->references('id')
                ->on('disciplines')
                ->nullOnDelete();

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->nullOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->enum('type', ['vacancy', 'load'])->default('load');
            $table->enum('characteristic', ['budget', 'commerce'])->default('budget');
            $table->unsignedBigInteger('hours');
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
        Schema::dropIfExists('loads');
    }
}
