<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Exception;
use Illuminate\Validation\Rule;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'curso',
        'paralelo',
        'arancel'
    ];
    /**
     * Get all of the estudiantes for the Curso
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function estudiantes(): HasMany
    {
        return $this->hasMany(Estudiante::class);
    }

    public function cantEstudiantes() {
        return $this->estudiantes()->count();
    }

    public function regulares() {
        return $this->estudiantes()->where('prioridad', 'alumno regular');
    }

    public function prioritarios() {
        return $this->estudiantes()->where('prioridad', 'prioritario');
    }

    public function nuevosPrioritarios() {
        return $this->estudiantes()->where('prioridad', 'nuevo prioritario');
    }

    private function rules(): array {
        return [
            'arancel' => 'required'
        ];
    }

    private function messages(): array {
        return [
            'required' => 'El campo :attribute es obligatorio',
        ];
    }

    private function attributes(): array {
        return [
            'arancel'
        ];
    }

    public function actualizar($id, $req) {
        $req->validate($this->rules(), $this->messages(), $this->attributes());
        try {
            Curso::find($id)->update($req->all());
            return ['status' => 200, 'message' => 'Curso actualizado con éxito']; 
        } catch(Exception $e) {
            return ['status' => 400, 'message' => 'No se pudo actualizar el curso', 'cursoErr' => $req->except('_token')];
        }
    }

    public function eliminar($id) {
        try {
            Curso::find($id)->delete();
            return ['status' => 200, 'message' => 'Curso eliminado con éxito']; 
        } catch(Exception $e) {
            return ['status' => 400, 'message' => 'No se pudo eliminar el curso'];
        }
    }
}
