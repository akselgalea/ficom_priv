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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->enum('mes', ['matricula', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre']);
            $table->string('anio');
            $table->enum('documento', ['boleta', 'recibo']);
            $table->string('num_documento');
            $table->string('fecha_pago');
            $table->string('valor');
            $table->enum('forma', ['efectivo', 'cheque', 'transferencia']);
            $table->text('observacion');
            $table->bigInteger('estudiante_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('estudiante_id')
                ->references('id')
                ->on('estudiantes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};
