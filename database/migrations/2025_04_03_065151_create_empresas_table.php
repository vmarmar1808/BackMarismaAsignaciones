<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('cif', 9)->unique();
            $table->string('sector', 100);
            $table->string('direccion');
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('representante');
            $table->string('representante_nif', 9);
            $table->string('tutor_laboral');
            $table->string('tutor_laboral_nif', 9);
            $table->integer('plazas_disponibles');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
