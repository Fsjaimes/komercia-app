<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    /**
     * Tabla asociada (opcional si coincide con el plural del modelo)
     */
    protected $table = 'products';

    /**
     * Campos que se pueden asignar en masa (mass assignment)
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'estado',
        'observaciones',
        'id_usuario_crea',
        'id_usuario_modifica',
        'created_at',
        'updated_at',
    ];

    /**
     * Laravel ya maneja created_at y updated_at
     */
    public $timestamps = true;
}
