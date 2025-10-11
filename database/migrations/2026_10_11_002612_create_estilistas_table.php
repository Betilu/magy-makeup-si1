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
        Schema::create('estilistas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('horario_id')
              ->constrained('horarios')
              ->onDelete('cascade');
            $table->foreignId('user_id')
              ->constrained('users')
              ->onDelete('cascade');

            $table->integer('calificacion');
            $table->double('comision', 10, 2)->default(0.00);
            $table->string('disponibilidad');
            $table->string('especialidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estilistas');
    }
};
