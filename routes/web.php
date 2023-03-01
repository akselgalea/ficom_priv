<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\BecaController;
use App\Http\Controllers\CursoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('registros')->group(function () {
        Route::get('/subir', function () {
            return view('registros.subir');
        })->name('subidaMasiva');
        
        Route::post('/subir', [EstudianteController::class, 'storeMassive'])->name('subirReg');
    });

    Route::group(['middleware' => ['check.role:admin|contabilidad']], function () {
        //Estudiante
        Route::get('/estudiantes/{id}/becas', [EstudianteController::class, 'becaEdit'])->name('estudiante.beca.edit');
        Route::post('/estudiantes/{id}/becas', [EstudianteController::class, 'becaUpdate'])->name('estudiante.beca.update');
        Route::delete('/estudiantes/{id}/becas', [EstudianteController::class, 'becaDelete'])->name('estudiante.beca.delete');
        Route::get('/estudiantes/{id}/pagos', [EstudianteController::class, 'pagos'])->name('estudiante.pagos');
        Route::post('/estudiantes/{id}/registrar-pago', [EstudianteController::class, 'storePago'])->name('pago.store');
        
        //Becas
        Route::get('/becas/nueva', [BecaController::class, 'create'])->name('beca.create');
        Route::post('/becas/nueva', [BecaController::class, 'store'])->name('beca.store');
        Route::get('/becas/{id}/editar', [BecaController::class, 'edit'])->name('beca.edit');
        Route::post('/becas/{id}/editar', [BecaController::class, 'update'])->name('beca.update');
        Route::delete('/becas/{id}/borrar', [BecaController::class, 'destroy'])->name('beca.delete');
        
        //Cursos
        Route::get('/cursos', [CursoController::class, 'index'])->name('curso.index');
        Route::get('/cursos/{id}', [CursoController::class, 'show'])->name('curso.show');
        Route::get('/cursos/{id}/editar', [CursoController::class, 'edit'])->name('curso.edit');
        Route::post('/cursos/{id}/editar', [CursoController::class, 'update'])->name('curso.update');
    });
    
    Route::group(['middleware' => ['check.role:admin|matriculas']], function () {
        Route::get('/estudiantes/nuevo', [EstudianteController::class, 'create'])->name('estudiante.create');
        Route::post('/estudiantes/crear', [EstudianteController::class, 'store'])->name('estudiante.store');
        Route::post('/estudiantes/{id}/editar', [EstudianteController::class, 'update'])->name('estudiante.update');
        Route::delete('/estudiantes/{id}/apoderados/{apoderado}', [EstudianteController::class, 'apoderadoRemove'])->name('estudiante.apoderado.remove');
    });
    
    //Estudiante
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiante.index');
    Route::get('/estudiantes/nuevos', [EstudianteController::class, 'getEstudiantesNuevos'])->name('estudiante.nuevos');
    Route::get('/estudiantes/{id}', [EstudianteController::class, 'show'])->name('estudiante.show');
    
    //Becas
    Route::get('/becas', [BecaController::class, 'index'])->name('beca.index');
    Route::get('/becas/{id}', [BecaController::class, 'show'])->name('beca.show');
});
