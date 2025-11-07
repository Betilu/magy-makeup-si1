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
        Schema::table('citas', function (Blueprint $table) {
            $table->foreignId('estilista_id')->nullable()->after('user_id')
                ->constrained('estilistas')->onDelete('set null');
            $table->foreignId('servicio_id')->nullable()->after('estilista_id')
                ->constrained('servicios')->onDelete('set null');
            $table->decimal('precio_total', 10, 2)->default(0)->after('anticipo');
            $table->decimal('comision_estilista', 10, 2)->default(0)->after('precio_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['estilista_id']);
            $table->dropForeign(['servicio_id']);
            $table->dropColumn(['estilista_id', 'servicio_id', 'precio_total', 'comision_estilista']);
        });
    }
};
