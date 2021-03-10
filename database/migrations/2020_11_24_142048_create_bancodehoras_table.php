<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBancodehorasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancodehoras', function (Blueprint $table) {
            $table->id();
            $table->text('justificativa');
            $table->integer('tipo');
            $table->integer('autor_id');
            $table->integer('funcionario_id');
            $table->string('total');
            $table->timestamp('data_ini');
            $table->timestamp('data_fim');
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('bancodehoras');
    }
}
