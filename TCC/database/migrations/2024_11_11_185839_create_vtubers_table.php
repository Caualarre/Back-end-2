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
            $table->unsignedBigInteger('empresa_id'); // Adicionando a chave estrangeira
            $table->string('descricao');
            $table->string('imagem');
            $table->timestamps();
    
            // Adicionando a relação com a tabela 'empresas'
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
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
