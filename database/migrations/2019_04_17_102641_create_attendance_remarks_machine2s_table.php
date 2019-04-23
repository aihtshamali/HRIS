<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRemarksMachine2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_remarks_machine2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comments');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('attendance_users_machine2')->onDelete('cascade');
            $table->date('date');
            $table->boolean('status')->default('true');
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
        Schema::dropIfExists('attendance_remarks_machine2');
    }
}
