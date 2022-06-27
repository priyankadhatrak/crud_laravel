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
        DB::statement("
        CREATE VIEW hobbyview
        AS
        SELECT employees_hobby.e_id,employees_hobby.h_id,hobby.hobby FROM employees_hobby INNER JOIN hobby ON employees_hobby.h_id = hobby.h_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hobby');
    }
};
