<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contributions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->decimal('monthlyContribution', 10, 3);
            $table->date('startDate');
            $table->timestamps();

            //foriegn key constraints to avoid orphans
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');
        });




        Schema::create('contri_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userFromId')->unique();
            $table->integer('userToId')->unique();
            $table->decimal('contri_value');
            $table->date('start_month');
            $table->string('status');
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
        Schema::dropIfExists('contributions');

        Schema::dropIfExists('contri_requests');
    }
}
