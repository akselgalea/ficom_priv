<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $fillable = [
        'id',
        'mes',
        'anio',
        'documento',
        'num_documento',
        'fecha_pago',
        'valor',
        'forma',
        'observacion',
        'estudiante_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the estudiante that owns the Pago
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function rules($id = null): array {
        return [
            'mes' => 'required',
            'anio' => 'required',
            'documento' => 'required',
            'num_documento' => ['required', Rule::unique('pagos')->ignore($id)],
            'fecha_pago' => 'required',
            'valor' => 'required',
            'forma' => 'required',
            'observacion' => 'required'
        ];
    }

    public function messages(): array {
        return [
            'nombre.unique' => 'Este documento ya se encuentra registrado',
            'required' => 'El campo :attribute es obligatorio',
            'min' => 'El campo :attribute requiere un minimo de :min caracteres',
            'max' => 'El campo :attribute requiere un maximo de :max caracteres'
        ];
    }

    public function attributes(): array {
        return [
            'mes',
            'anio' => 'año',
            'documento',
            'num_documento' => 'numero de documento',
            'fecha_pago' => 'fecha de pago',
            'valor',
            'forma',
            'observacion'
        ];
    }
}
