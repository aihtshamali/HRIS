<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceRemarksMachine1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_remarks_machine1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('comments');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('attendance_users_machine1')->onDelete('cascade');
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
        Schema::dropIfExists('attendance_remarks_machine1');
    }
}
