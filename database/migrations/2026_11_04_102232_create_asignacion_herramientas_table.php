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
        Schema::create('asignacion_herramientas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('herramienta_id');
            $table->foreign('herramienta_id')->references('id')->on('herramientas')->onDelete('cascade');
            $table->unsignedBigInteger('estilista_id');
            $table->foreign('estilista_id')->references('id')->on('estilistas')->onDelete('cascade');
            $table->unsignedBigInteger('recepcionista_id'); // ID del usuario (recepcionista)
            $table->foreign('recepcionista_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('estadoEntrega');
            $table->string('estadoDevolucion');
            $table->date('fechaAsignacion');
            $table->date('fechaDevolucion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_herramientas');
    }
};
