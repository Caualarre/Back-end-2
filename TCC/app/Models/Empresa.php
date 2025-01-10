<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'descricao',
        'localizacao'
    ];

    // Relacionamento: 1 Empresa tem muitos VTubers
    public function vtubers()
    {
        return $this->hasMany(Vtuber::class);
    }
}
