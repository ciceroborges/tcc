<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            // columns
            $table->id();
            $table->unsignedBigInteger('appointment_id');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['WAITING', 'IN PROGRESS', 'CANCELED', 'CONCLUDED']);
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();
            // foreign keys
            $table->foreign('appointment_id')->references('id')->on('appointments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
