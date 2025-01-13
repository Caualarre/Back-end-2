<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Vtuber extends Model
{
    use HasFactory;
    protected $fillable = [
        'nome',
        'descricao',
        'imagem',
        'empresa_id',
    ];

    // Relacionamento: Vtuber avaliada por vários usuários
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_vtuber')
                    ->withPivot('nota', 'comentario')
                    ->withTimestamps();
    }

    // Escopo para calcular média de notas via subquery (para listas)
    public static function withMediaNotas()
    {
        return self::query()->withCount(['usuarios as media_nota' => function (Builder $query) {
            $query->select(DB::raw('avg(usuario_vtuber.nota)'));
        }]);
    }

    // Acessor para calcular média de notas dinamicamente (para detalhes)
    // Acessor para calcular média de notas dinamicamente (para detalhes)
public function getMediaNotaAttribute()
{
    // Calcula a média das notas dos usuários associados
    $mediaNota = $this->usuarios()->avg('usuario_vtuber.nota');

    // Retorna a média formatada com 2 casas decimais
    return number_format($mediaNota, 2, '.', '');
}


     // Scopes locais
     public function scopeFilterByName(Builder $query, $name)
{
    if ($name) {
        return $query->where('nome', 'like', '%' . $name . '%');
    }
}

 
public function scopeFilterByEmpresa(Builder $query, $empresa)
{
    if ($empresa) {
        return $query->where('empresa_id', 'like', '%' . $empresa . '%');  
    }
}

     
     
     public function scopeFilterByMedia(Builder $query, $media)
     {
         if ($media) {
             return $query->whereHas('usuarios', function (Builder $q) use ($media) {
                 $q->select(DB::raw('AVG(usuario_vtuber.nota) as media_nota'))
                   ->groupBy('usuario_vtuber.vtuber_id')  
                   ->havingRaw('AVG(usuario_vtuber.nota) >= ?', [$media]);
             });
         }
     }
     
     
}
