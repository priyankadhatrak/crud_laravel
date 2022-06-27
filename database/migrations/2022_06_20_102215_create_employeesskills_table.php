<?php

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
        Schema::create('employees_skills', function (Blueprint $table) {
            $table->unsignedBigInteger('e_id');
            $table->foreign('e_id')->references('e_id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('s_id');
            $table->foreign('s_id')->references('s_id')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_skills');
    }
};
