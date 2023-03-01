<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Estudiante;
use App\Models\Beca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class EstudianteController extends Controller
{
    private $estud;
    public function __construct(Estudiante $estud)
    {
        $this->estud = $estud;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {   
        $data = $this->estud->index($req);
        return view('estudiante.listar', ['estudiantes' => $data['estudiantes'], 'perPage' => $data['perPage'], 'cursos' => Curso::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $req)
    {
        return redirect()->back()->with('res', $this->estud->store($req));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        return view('estudiante.perfil', $this->estud->show($id));
    }

    public function getEstudiantesNuevos(Request $req) {
        $perPage = request('perPage', '10');
        $estudiantes = $this->estud::with('curso')->where('es_nuevo', true)->latest()->paginate($perPage);
        
        return view('estudiante.listar')->with(['estudiantes' => $estudiantes, 'cursos' => Curso::all(), 'perPage' => $perPage]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $req)
    {
        return view('estudiante.crear', ['cursos' => Curso::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudiante  $estudiante
     */
    public function edit($id)
    {
        return view('estudiante.editar');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudiante  $estudiante
     */
    public function update($id, Request $req)
    {
        return redirect()->back()->with('res', $this->estud->actualizar($id, $req));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudiante  $estudiante
     */
    public function destroy($id)
    {
        return null;
    }


    /* Pagos ------------------------------------------- */
    /**
     * Store massively resources in storage.
     *
     * @param int   $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function storePago($id, Request $req) {
        return redirect()->back()->with('res', $this->estud->storePago($id, $req));
    }

    public function pagos($id)
    {
        $estudiante = $this->estud::with('curso', 'beca')->find($id);
        $estudiante->pagos_anio = $estudiante->pagosPorAnio('2023');
        $estudiante->apoderado_titular = $estudiante->apoderadoTitular()->first();

        return view('estudiante.pagos', ['estudiante' => $estudiante]);
    }

    public function becaEdit($id) {
        return view('estudiante.beca', ['estudiante' => $this->estud::with('beca', 'curso')->find($id), 'becas' => Beca::all()]);
    }

    public function becaUpdate($id, Request $req) {
        return redirect()->back()->with('res', $this->estud->becaUpdate($id, $req));
    }

    public function becaDelete($id) {
        return redirect()->back()->with('res', $this->estud->becaDelete($id));
    }

    public function apoderadoRemove($id, $apoderado) {
        return $this->estud->apoderadoRemove($id, $apoderado);
    }

    
    /**
     * Store massively resources in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function storeMassive(Request $request)
    {
        try {
            $request->validate([
                "tipoRegistro"=>"required",
                "file"=>"required"
            ]);

            if($request->tipoRegistro == "nomina"){

                $request->validate(["file"=> "mimes:xml"]);
                $file = $request->file('file');
                $a = Storage::disk('local')->put('docs',$file);
                $process = new Process([
                    'python',
                    storage_path('app\xml\dataConverter.py'),
                    storage_path('app/'.$a)
                ]);
                $process->run();

                // executes after the command finishes
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
                return redirect()->back()->with('res', ['status' => 200, 'message' => 'Registros subidos con éxito']);
            }
            elseif($request->tipoRegistro == "prioritarios"){
                $request->validate(["file"=> "mimes:xlsx"]);
                $file = $request->file('file');
                $a = Storage::disk('local')->put('docs',$file);
                $process = new Process([
                    'python',
                    storage_path('app\xml\dataConverter2.py'),
                    storage_path('app/'.$a)
                ]);
                $process->run();

                // executes after the command finishes
                if (!$process->isSuccessful()) {
                    throw new ProcessFailedException($process);
                }
                return redirect()->back()->with('res', ['status' => 200, 'message' => 'Registros subidos con éxito']);
            }
            else{
                return redirect()->back()->with('res', ['status' => 400, 'message' => 'Error al subir el registro']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}