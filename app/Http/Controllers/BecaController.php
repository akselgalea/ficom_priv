<?php

namespace App\Http\Controllers;

use App\Models\Beca;
use Illuminate\Http\Request;
use Exception;

class BecaController extends Controller
{
    private $beca;
    
    public function __construct(Beca $beca)
    {
        $this->beca = $beca;
    }

    public function index() {
        return view('becas.index', ['becas' => Beca::all()]);
    }

    public function show($id) {
        return view('becas.mostrar', ['beca' => Beca::find($id)]);
    }

    public function create() {
        return view('becas.crear');
    }

    public function store(Request $req) {
        return $this->beca->store($req);
    }

    public function edit($id) {
        return $this->beca->edit($id);
    }

    public function update($id, Request $req) {
        return $this->beca->actualizar($id, $req);
    }

    public function destroy($id) {
        $this->beca->borrar($id);
    }
}
