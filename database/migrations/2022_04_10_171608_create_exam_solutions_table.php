<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_solutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string("result");
            $table->json("solutions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_solutions');
    }
}
