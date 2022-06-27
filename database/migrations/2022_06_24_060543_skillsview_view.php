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
        CREATE VIEW skills_view
        AS
        SELECT employees_skills.e_id, employees_skills.s_id,skills.language 
        FROM employees_skills 
        INNER JOIN skills ON employees_skills.s_id = skills.s_id");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills_view');
    }
};
