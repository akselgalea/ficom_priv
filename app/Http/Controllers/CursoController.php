<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use Exception;

class CursoController extends Controller
{
    private $curso;
    public function __construct(Curso $curso)
    {
        $this->curso = $curso;
    }

    public function index() {
        return view('curso.index', ['cursos' => $this->curso::all()]);
    }

    public function show($id) {
        return view('curso.mostrar', ['curso' => $this->curso::with('estudiantes')->find($id)]);
    }

    public function create() {

    }

    public function store() {

    }

    public function edit($id) {
        return view('curso.editar', ['curso' => Curso::with('estudiantes')->find($id)]);
    }

    public function update($id, Request $req) {
        return redirect()->back()->with('res', $this->curso->actualizar($id, $req));
    }

    public function destroy($id) {
        $res = $this->curso->eliminar($id);
        if($res['status'] == 400) return redirect()->back()->with('res', $res);

        return redirect()->route('beca.index')->with('res', $res); 
    }
}
