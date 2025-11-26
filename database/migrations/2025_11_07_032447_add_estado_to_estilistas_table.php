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
        Schema::table('estilistas', function (Blueprint $table) {
            $table->enum('estado', ['nuevo', 'antiguo'])->default('nuevo')->after('especialidad');
            $table->decimal('total_comisiones', 10, 2)->default(0)->after('comision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estilistas', function (Blueprint $table) {
            $table->dropColumn(['estado', 'total_comisiones']);
        });
    }
};
