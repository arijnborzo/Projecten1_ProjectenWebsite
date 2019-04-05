<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('Id');
            $table->enum('Belbintype', ['Bedrijfsman', 'Brononderzoeker', 'Plant', 'Monitor', 'Vormer', 'Voozitter', 'Zorgdrager', 'Groepsdrager', 'Specialist']);
            $table->integer('Group_id')
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}