<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApoderadoEstudiante extends Model
{
    use HasFactory;

    protected $table = 'apoderado_estudiante';
    protected $fillable = [
        'apoderado_id',
        'estudiante_id',
        'es_suplente'
    ];

    protected $casts = [
        'es_suplente' => 'boolean'
    ];

    public function apoderado() {
        return $this->belongsToMany(Apoderado::class);
    }

    public function estudiante() {
        return $this->belongsToMany(Estudiante::class);
    }
}
