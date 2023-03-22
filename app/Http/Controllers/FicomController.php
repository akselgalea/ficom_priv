<?php

namespace App\Http\Controllers;

use App\Exports\EstudiantesExport;
use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FicomController extends Controller
{
    private $est;
    
    public function __construct(Estudiante $est)
    {
        $this->est = $est;
    }


    public function createReport($id) {
        return Excel::download(new EstudiantesExport($id), "{$this->est->find($id)->rut}-reporte-ficom.xlsx");
    }

    public function createReportAll() {
        return Excel::download(new EstudiantesExport, "reporte-ficom-todos.xlsx");
    }
}
