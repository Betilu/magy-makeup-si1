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
        Schema::table('servicios', function (Blueprint $table) {
            // Agregar precio_servicio si no existe
            if (!Schema::hasColumn('servicios', 'precio_servicio')) {
                $table->decimal('precio_servicio', 8, 2)->after('duracion')->default(0);
            }
            
            // Agregar estado si no existe
            if (!Schema::hasColumn('servicios', 'estado')) {
                $table->string('estado')->after('precio_servicio')->default('activo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            if (Schema::hasColumn('servicios', 'precio_servicio')) {
                $table->dropColumn('precio_servicio');
            }
            
            if (Schema::hasColumn('servicios', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};
