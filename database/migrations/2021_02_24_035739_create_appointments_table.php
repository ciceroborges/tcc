<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            // columns
            $table->id();
            $table->unsignedInteger('department_id');
            $table->unsignedBigInteger('patient_id');
            $table->text('anamnesis');
            //$table->text('complaint')->nullable();
            $table->enum('status', ['WAITING', 'IN PROGRESS', 'CANCELED', 'CONCLUDED']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // foreign keys
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('patient_id')->references('id')->on('patients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
