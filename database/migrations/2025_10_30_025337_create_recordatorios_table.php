<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recordatorios', function (Blueprint $table) {
            $table->id();
            $table->string('mensaje');
            $table->datetime('fecha_recordatorio');
            $table->boolean('enviado')->default(false);
            $table->foreignId('tarea_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recordatorios');
    }
};