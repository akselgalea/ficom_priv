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
        Schema::create('apoderado_estudiante', function (Blueprint $table) {
            $table->foreignId('apoderado_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('estudiante_id')->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('es_suplente')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apoderado_estudiante');
    }
};
