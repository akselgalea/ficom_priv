<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apoderado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'apellidos',
        'nombres',
        'telefono',
        'email',
        'direccion',
    ];

    /**
     * Get all of the protegido for the Apoderado
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function protegidos(): BelongsToMany
    {
        return $this->belongsToMany(Estudiante::class, 'apoderado_estudiante', 'estudiante_id', 'apoderado_id')->withPivot('es_suplente');
    }
}
