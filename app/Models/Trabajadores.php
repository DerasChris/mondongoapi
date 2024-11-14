<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Trabajadores extends Model
{
    protected $connection = 'mongodb';
    
    protected $collection = 'trabajadores';

    protected $fillable = [
        'usuarioId',
        'profesion',
        'categorias',
        'calificacion',
        'curriculum',
        'cantidadTrabajosRealizados',
        'aniosExperiencia',
        'descripcion',
    ];

    protected $casts = [
        'calificacion' => 'float',
        'cantidadTrabajosRealizados' => 'integer',
        'aniosExperiencia' => 'integer',
    ];

    // El método serializeDate solo es necesario si usas fechas en el modelo
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d\TH:i:s.u\Z'); // Formato ISO 8601
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioId', 'firebaseUID');
    }
}