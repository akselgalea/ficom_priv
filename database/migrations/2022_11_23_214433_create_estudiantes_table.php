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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('apellidos');
            $table->string('nombres');
            $table->enum('genero', ['M', 'F', 'N'])->default('N');
            $table->string('rut')->unique()->nullable()->default(null);
            $table->string('dv')->nullable()->default(null);
            $table->boolean('es_nuevo')->default(false);
            
            $table->enum('prioridad', array('alumno regular', 'prioritario', 'nuevo prioritario'))->default('alumno regular');
            $table->string('email_institucional')->nullable();
            $table->string('telefono')->default('')->nullable();
            $table->string('direccion')->default('')->nullable();
            $table->foreignId('curso_id')->nullable()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('beca_id')->nullable()->nullOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('estudiantes');
    }
};
