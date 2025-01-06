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
    Schema::create('vtubers', function (Blueprint $table) {
        $table->id();
        $table->string('nome');
        $table->string('empresa')->default('Independente'); // Define um valor padrão
        $table->string('descricao');
        $table->string('imagem')->default('default.png'); // Adiciona valor padrão para imagem
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vtubers');
    }
};
