<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Validation\Rule;

class Beca extends Model
{
    use HasFactory;

    protected $table = 'becas';

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'descuento'
    ];

    public function estudiantes(): HasMany {
        return $this->hasMany(Estudiante::class);
    }

    private function rules($id = null): array {
        return [
            'nombre' => ['required', 'max:255', Rule::unique('becas')->ignore($id)],
            'descuento' => 'required|min:1|max:100',
            'descripcion' => 'required|max:1000'
        ];
    }

    private function messages(): array {
        return [
            'descuento.min' => 'El campo descuento debe ser mayor a 1',
            'descuento.max' => 'El campo descuento debe ser menor o igual a 100',
            'nombre.unique' => 'Este nombre ya esta en uso',
            'required' => 'El campo :attribute es obligatorio',
            'min' => 'El campo :attribute requiere un minimo de :min caracteres',
            'max' => 'El campo :attribute requiere un maximo de :max caracteres'
        ];
    }

    private function attributes(): array {
        return [
            'nombre',
            'descuento',
            'descripcion'
        ];
    }

    public function store($req) {
        $req->validate($this->rules(), $this->messages(), $this->attributes());
        try {
            Beca::create($req->all());
            return redirect()->back()->with('res', ['status' => 200, 'message' => 'Beca creada con exito!']);
        } catch (Exception $e) {
            $message = $e->getMessage();
            if(str_contains($message, 'nombre_unique')) $message = 'Esta beca ya existe';

            return redirect()->back()->with('res', ['status' => 400, 'message' => $message, 'beca' => $req->except('_token')]);
        }
    }

    public function edit($id) {
        try {
            return view('becas.editar', ['beca' => Beca::findOrFail($id)]);
        } catch(Exception $e) {
            return redirect()->back()->with('res', ['status' => 400, 'message' => 'No se pudo encontrar esta beca']);
        }
    }

    public function actualizar($id, $req) {
        $req->validate($this->rules($id), $this->messages(), $this->attributes());
        try {
            Beca::findOrFail($id)->update($req->all());
            return redirect()->back()->with('res', ['status' => 200, 'message' => 'Beca actualizada con exito!']);
        } catch(Exception $e) {
            $message = $e->getMessage();
            if(str_contains($message, 'nombre_unique')) $message = 'Esta beca ya existe';
            return redirect()->back()->with('res', ['status' => 400, 'message' => $message]);
        }
    }

    public function borrar($id) {
        try {
            Beca::find($id)->delete();
            return redirect()->route('beca.index')->with('res', ['status' => 200, 'message' => 'Beca eliminada con éxito']); 
        } catch(Exception $e) {
            return redirect()->back()->with('res', ['status' => 400, 'message' => 'No se pudo eliminar la beca']);
        }
    }
}
