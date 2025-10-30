<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tareas', function (Blueprint $table) {
            // Agregar campos para el calendario
            $table->dateTime('fecha_inicio')->nullable()->after('fecha_entrega');
            $table->boolean('todo_el_dia')->default(false)->after('fecha_inicio');
            $table->string('ubicacion')->nullable()->after('todo_el_dia');
            
            // Cambiar fecha_entrega a datetime para eventos con hora específica
            $table->dateTime('fecha_entrega')->change();
        });
    }

    public function down()
    {
        Schema::table('tareas', function (Blueprint $table) {
            $table->dropColumn(['fecha_inicio', 'todo_el_dia', 'ubicacion']);
            $table->date('fecha_entrega')->change();
        });
    }
};