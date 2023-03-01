<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Freshwork\ChileanBundle\Exceptions\InvalidFormatException;
use Freshwork\ChileanBundle\Rut;
use Exception;
use Illuminate\Validation\Rule;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    protected $fillable = [
        'id',
        'nombres',
        'apellidos',
        'genero',
        'rut',
        'dv',
        'prioridad',
        'email_institucional',
        'telefono',
        'direccion',
        'es_nuevo',
        'curso_id',
        'beca_id'
    ];

    /**
     * Get the apoderados that owns the Estudiante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function apoderados(): BelongsToMany
    {
        return $this->belongsToMany(Apoderado::class, 'apoderado_estudiante', 'estudiante_id', 'apoderado_id')->withPivot('es_suplente');
    }

    public function apoderadoTitular()
    {
        return $this->apoderados()->wherePivot('es_suplente', false);
    }

    public function apoderadoSuplente()
    {
        return $this->apoderados()->wherePivot('es_suplente', true);
    }

    /**
     * Get the curso that owns the Estudiante
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function beca(): BelongsTo
    {
        return $this->belongsTo(Beca::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
    /**
     * Get all of the pagos for the Estudiante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function hasApoderadoTitular() : bool {
        return $this->apoderadoTitular->count() > 0;
    }

    public function hasApoderadoSuplente(): bool {
        return $this->apoderadoSuplente->count() > 0;
    }

    private function rules($hasApoderado, $hasApoderadoSuplente, $id = null): array {
        return [
            'nombres' => 'required|max:255',
            'apellidos' => 'sometimes|required|max:255',
            'apellido_paterno' => 'sometimes|required|max:255',
            'apellido_materno' => 'sometimes|required|max:255',
            'run' => 'required|max:10',
            'email_institucional' => ['sometimes', 'nullable', 'email', Rule::unique('estudiantes')->ignore($id)],
            'nivel' => 'required',
            'prioridad' => 'required',
            'a_nombres' => Rule::requiredIf($hasApoderado),
            'a_apellidos' => Rule::requiredIf($hasApoderado),
            'a_telefono' => [Rule::requiredIf($hasApoderado), 'min:8', 'max:12'],
            'a_email' => [Rule::requiredIf($hasApoderado), 'email'],
            'a_direccion' => Rule::requiredIf($hasApoderado),
            'sub_nombres' => Rule::requiredIf($hasApoderadoSuplente),
            'sub_apellidos' => Rule::requiredIf($hasApoderadoSuplente),
            'sub_telefono' => [Rule::requiredIf($hasApoderadoSuplente), 'min:8', 'max:12'],
            'sub_email' => [Rule::requiredIf($hasApoderadoSuplente), 'email'],
            'sub_direccion' => Rule::requiredIf($hasApoderadoSuplente)
        ];
    }

    private function messages(): array {
        return [
            'required' => 'El campo :attribute es obligatorio',
            'email_institucional.unique' => 'Este correo ya esta en uso',
            'min' => 'El campo :attribute requiere un minimo de :min caracteres',
            'max' => 'El campo :attribute requiere un maximo de :max caracteres'
        ];
    }

    private function attributes(): array {
        return [
            'nombres',
            'apellidos',
            'apellido_paterno' => 'apellido paterno',
            'apellido_materno' => 'apellido materno',
            'run',
            'email_institucional' => 'correo institucional',
            'nivel',
            'prioridad',
            'a_nombres' => 'nombres',
            'a_apellidos' => 'apellidos',
            'a_telefono' => 'telefono',
            'a_email' => 'email',
            'a_direccion' => 'direccion',
            'sub_nombres' => 'nombres',
            'sub_apellidos' => 'apellidos',
            'sub_telefono' => 'telefono',
            'sub_email' => 'email',
            'sub_direccion' => 'direccion'
        ];
    }

    public function index($req)
    {
        $perPage = request('perPage', 10);
        $curso = request('curso', 'todos');
        //Busqueda y firtrado por Temas
        if ($curso != 'todos') {
            if ($req->search) {
                $estudiantes = Estudiante::with('curso')
                    ->searchByName($req->search)
                    ->searchBySurname($req->search)
                    ->searchByRut($req->search)
                    ->paginate($perPage);

                return ['estudiantes' => $estudiantes, 'perPage' => $perPage];
            }

            return ['estudiantes' => Estudiante::with(['curso'])->where('curso_id', $curso)->paginate($perPage), 'perPage' => $perPage];
        }

        //Solo Busqueda
        if ($req->search) {
            return [
                'estudiantes' => Estudiante::with(['curso'])
                    ->searchByName($req->search)
                    ->searchBySurname($req->search)
                    ->searchByRut($req->search)
                    ->paginate($perPage),
                'perPage' => $perPage
            ];
        }

        return ['estudiantes' => Estudiante::with('curso')->paginate($perPage), 'perPage' => $perPage];
    }

    public function show($id)
    {
        $estudiante = Estudiante::with('curso', 'beca')->find($id);
        $estudiante->apoderado_titular = $estudiante->apoderadoTitular()->first();
        $estudiante->apoderado_suplente = $estudiante->apoderadoSuplente()->first();

        return ['estudiante' => $estudiante, 'cursos' => Curso::all(), 'becas' => Beca::all()];
    }

    public function pagosPorAnio($anio)
    {
        $pagos_anio = $this->pagos()->where('anio', $anio)->oldest()->get();

        return [
            'matricula' => $pagos_anio->where('mes', 'matricula'),
            'marzo' => $pagos_anio->where('mes', 'marzo'),
            'abril' => $pagos_anio->where('mes', 'abril'),
            'mayo' => $pagos_anio->where('mes', 'mayo'),
            'junio' => $pagos_anio->where('mes', 'junio'),
            'julio' => $pagos_anio->where('mes', 'julio'),
            'agosto' => $pagos_anio->where('mes', 'agosto'),
            'septiembre' => $pagos_anio->where('mes', 'septiembre'),
            'octubre' => $pagos_anio->where('mes', 'octubre'),
            'noviembre' => $pagos_anio->where('mes', 'noviembre'),
            'diciembre' => $pagos_anio->where('mes', 'diciembre')
        ];
    }

    public function mesFaltante($pagos, $totalAPagar)
    {
        foreach ($pagos as $mes => $pagosMes) {
            if ($mes != 'matricula') {
                if (count($pagosMes) == 0)
                    return $mes;

                $total = 0;
                foreach ($pagosMes as $pago)
                    $total += $pago->valor;
                if ($total < $totalAPagar)
                    return $mes;
            }
        }
    }

    public function scopeSearchByName($query, $text)
    {
        if ($text)
            $query->orWhere('nombres', 'LIKE', "%$text%");
    }

    public function scopeSearchBySurname($query, $text)
    {
        if ($text)
            $query->orWhere('apellidos', 'LIKE', "%$text%");
    }

    public function scopeSearchByRut($query, $text)
    {
        if ($text)
            $query->orWhere('rut', 'LIKE', "%$text%");
    }

    public function store($req)
    {
        $hasApoderado = $req->a_nombres != '' || $req->a_apellidos != '' || $req->a_telefono != '' || $req->a_email != '' || $req->a_direccion != '';
        $hasApoderadoSuplente = $req->sub_nombres != '' || $req->sub_apellidos != '' || $req->sub_telefono != '' || $req->sub_email != '' || $req->sub_direccion != '';

        $req->validate(
            $this->rules($hasApoderado, $hasApoderadoSuplente),
            $this->messages(),
            $this->attributes()
        );

        try {
            Rut::parse($req->run)->validate();
            $rut = Rut::parse($req->run)->format(Rut::FORMAT_ESCAPED);
            $rut = Rut::parse($rut)->toArray();

            //Estudiante
            $estudiante = new Estudiante();
            $estudiante->nombres = $req->nombres;
            $estudiante->apellidos = $req->apellido_paterno . ' ' . $req->apellido_materno;
            $estudiante->rut = $rut[0];
            $estudiante->dv = $rut[1];
            $estudiante->es_nuevo = 1;
            $estudiante->direccion = $req->direccion;
            $estudiante->telefono = $req->telefono;
            $estudiante->curso_id = $req->nivel;
            $estudiante->prioridad = $req->prioridad;
            $estudiante->save();

            //Apoderado
            if ($hasApoderado) {
                $apoderado = new Apoderado();
                $apoderado->apellidos = $req->a_apellidos;
                $apoderado->nombres = $req->a_nombres;
                $apoderado->telefono = $req->a_telefono;
                $apoderado->email = $req->a_email;
                $apoderado->direccion = $req->a_direccion;

                $estudiante->apoderados()->save($apoderado);
            }

            //Apoderado suplente
            if ($hasApoderadoSuplente) {
                $apoderado_sub = new Apoderado();
                $apoderado_sub->apellidos = $req->sub_apellidos;
                $apoderado_sub->nombres = $req->sub_nombres;
                $apoderado_sub->telefono = $req->sub_telefono;
                $apoderado_sub->email = $req->sub_email;
                $apoderado_sub->direccion = $req->sub_direccion;
                $estudiante->apoderados()->save($apoderado_sub, ['es_suplente' => true]);
            }

            return ['status' => 200, 'message' => 'Estudiante creado con exito!'];
        } catch (InvalidFormatException $e) {
            $message = "RUT Incorrecto";
            return ['status' => 400, 'message' => $message];
        } catch (Exception $e) {
            $message = 'Ha ocurrido un error';
            if (str_contains($e->getMessage(), 'apoderado'))
                $message = $e->getMessage();
            if (str_contains($e->getMessage(), 'estudiantes_rut_unique'))
                $message = 'Este estudiante ya se encuentra registrado';

            return ['status' => 400, 'message' => $message];
        }
    }

    public function actualizar($id, $request)
    {
        $hasApoderado = $request->a_nombres != '' || $request->a_apellidos != '' || $request->a_telefono != '' || $request->a_email != '' || $request->a_direccion != '';
        $hasApoderadoSuplente = $request->sub_nombres != '' || $request->sub_apellidos != '' || $request->sub_telefono != '' || $request->sub_email != '' || $request->sub_direccion != '';

        $request->validate(
            $this->rules($hasApoderado, $hasApoderadoSuplente, $id),
            $this->messages(),
            $this->attributes()
        );

        try {
            $estudiante = Estudiante::findOrFail($id);
            Rut::parse($request->run)->validate();
            $rut = Rut::parse($request->run)->format(Rut::FORMAT_ESCAPED);
            $rut = Rut::parse($rut)->toArray();

            $estudiante->apellidos = $request->apellidos;
            $estudiante->nombres = $request->nombres;
            $estudiante->rut = $rut[0];
            $estudiante->dv = $rut[1];
            $estudiante->email_institucional = $request->email_institucional;
            $estudiante->prioridad = $request->prioridad;
            if ($estudiante->prioridad == 'prioritario') $estudiante->beca()->dissociate();
            $estudiante->curso_id = $request->nivel;
            $estudiante->telefono = $request->a_telefono;
            $estudiante->direccion = $request->a_direccion;
            
            if($hasApoderado) {
                if(!$estudiante->hasApoderadoTitular()) {
                    $apoderado = new Apoderado();
                    $apoderado->nombres = $request->a_nombres;
                    $apoderado->apellidos = $request->a_apellidos;
                    $apoderado->telefono = $request->a_telefono;
                    $apoderado->email = $request->a_email;
                    $apoderado->direccion = $request->a_direccion;
                    $estudiante->apoderados()->save($apoderado);
                } else {
                    $estudiante->apoderadoTitular()->update([
                        'apellidos' => $request->a_apellidos,
                        'nombres' => $request->a_nombres,
                        'telefono' => $request->a_telefono,
                        'email' => $request->a_email,
                        'direccion' => $request->a_direccion,
                    ]);
                }
            }

            if($hasApoderadoSuplente) {
                if (!$estudiante->hasApoderadoSuplente()) {
                    $apoderado = new Apoderado();
                    $apoderado->apellidos = $request->sub_apellidos;
                    $apoderado->nombres = $request->sub_nombres;
                    $apoderado->telefono = $request->sub_telefono;
                    $apoderado->email = $request->sub_email;
                    $apoderado->direccion = $request->sub_direccion;
                    $estudiante->apoderados()->save($apoderado, ['es_suplente' => true]);
                } else {
                    $estudiante->apoderadoSuplente()->update([
                        'apellidos' => $request->sub_apellidos,
                        'nombres' => $request->sub_nombres,
                        'telefono' => $request->sub_telefono,
                        'email' => $request->sub_email,
                        'direccion' => $request->sub_direccion,
                    ]);
                }
            }

            $estudiante->save();
            return ['status' => 200, 'message' => 'Estudiante actualizado con exito!'];
        } catch (Exception $e) {
            return ['status' => 400, 'message' => $e->getMessage()];
        }
    }

    public function storePago($id, $req)
    {
        $pago = new Pago;
        $req->validate($pago->rules(), $pago->messages(), $pago->attributes());
        
        try {
            Estudiante::find($id)->pagos()->create($req->all());
            return ['status' => 200, 'message' => 'Pago registrado con éxito'];
        } catch (Exception $e) {
            return ['status' => 400, 'message' => 'Ha ocurrido un error'];
        }
    }

    public function becaUpdate($id, $req)
    {
        try {
            $estudiante = Estudiante::find($id);
            if ($estudiante->prioridad == 'prioritario')
                return ['status' => 400, 'message' => 'No se puede asignar becas a un estudiante prioritario'];

            $estudiante->beca()->associate($req->beca_id)->save();
            return ['status' => 200, 'message' => 'Beca asignada con éxito'];
        } catch (Exception $e) {
            return ['status' => 400, 'message' => 'Ha ocurrido un error', 'datos' => $req->except('_token')];
        }
    }

    public function becaDelete($id)
    {
        try {
            Estudiante::find($id)->beca()->dissociate()->save();
            return ['status' => 200, 'message' => 'Beca removida con éxito'];
        } catch (Exception $e) {
            return ['status' => 400, 'message' => 'Ha ocurrido un error'];
        }
    }

    public function registrosFicom($req)
    {
        return [
            'RBD' => $req['rbd'],
            'Posee RUN' => $this->poseeRun(),
            'RUN alumno' => $this->rut . '-' . $this->dv,
            'DV alumno' => $this->dv,
            'Annio mensualidad percibida' => $req['anio'],
            'Monto total mensualidad' => $this->totalMensualidades($req['anio']),
            'Monto total intereses y/o gastos de cobranza' => 0,
            'Cantidad de mensualidades' => $this->mesesPagados($req['anio']),
            'Tipo de Documento' => $req['tipoDocumento']
        ];
    }

    public function poseeRun()
    {
        if ($this->rut)
            return 1;
        return 2;
    }

    public function mesesPagados($anio)
    {
        $cantidad = 0;

        foreach ($this->pagosPorAnio($anio) as $mes => $pagosMes) {
            if ($mes != 'matricula') {
                if (count($pagosMes) == 0)
                    continue;
                $total = 0;
                foreach ($pagosMes as $pago)
                    $total += $pago->valor;
                if ($total == $this->curso->arancel)
                    $cantidad++;
            }
        }

        return $cantidad;
    }

    public function totalMensualidades($anio)
    {
        $total = 0;

        foreach ($this->pagosPorAnio($anio) as $mes => $pagosMes)
            if ($mes != 'matricula') foreach ($pagosMes as $pago)
                    $total += $pago->valor;

        return $total;
    }

    public function mesesPorPagar($anio)
    {
        $meses = [];
        foreach ($this->pagosPorAnio($anio) as $mes => $pagosMes) {
            $total = 0;
            foreach ($pagosMes as $pago)
                $total += $pago->valor;
            if ($total < $this->curso->arancel)
                array_push($meses, ['mes' => $mes, 'pagado' => $total, 'falta' => $this->curso->arancel - $total]);
        }

        return $meses;
    }

    public function apoderadoRemove($id, $apoderado) {
        try {
            Estudiante::findOrFail($id)->apoderados()->detach($apoderado);
            return redirect()->back()->with('res', ['status' => 200, 'message' => 'Apoderado removido del estudiante con exito']);
        } catch(Exception $e) {
            return redirect()->back()->with('res', ['status' => 400, 'message' => 'No se pudo remover al apoderado']);
        }
    }
}