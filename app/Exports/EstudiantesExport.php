<?php

namespace App\Exports;

use App\Models\Estudiante;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EstudiantesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $id;
    public function __construct($id = null) {
        $this->id = $id;
    }

    public function view(): View
    {
        $registros = [];

        if($this->id) {
            array_push($registros, Estudiante::find($this->id)->registrosFicom('2023'));
        }
        
        else {
            $estudiantes = Estudiante::all();

            foreach($estudiantes as $estudiante) {
                array_push($registros, $estudiante->registrosFicom('2023'));
            }
        }

        return view('registros.export', ['registros' => $registros]);
    }
}
