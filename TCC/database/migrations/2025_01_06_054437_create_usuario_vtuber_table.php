<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('usuario_vtuber', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id'); // Chave estrangeira para o usuário
            $table->unsignedBigInteger('vtuber_id'); // Chave estrangeira para o vtuber
            $table->integer('nota')->min(1)->max(10); // Nota dada pelo usuário (1 a 10)
            $table->text('comentario')->nullable(); // Comentário do usuário
            $table->timestamps();

            // Definindo as chaves estrangeiras
            $table->foreign('usuario_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->foreign('vtuber_id')->references('id')->on('vtubers')->onDelete('cascade');

            // Garantir que a combinação usuario_id + vtuber_id seja única
            $table->unique(['usuario_id', 'vtuber_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_vtuber');
    }
};
