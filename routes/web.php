<?php

use App\Http\Controllers\Admin\CertificadosController;
use App\Http\Controllers\BuscarCertificadoController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\DocentesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\NoticiasController;


Route::get('/', HomeController::class)->name('Home');

Route::get('cursos', [CursosController::class, 'index'])->name('curso.index');
Route::get('curso/{curso}', [CursosController::class, 'show'])->name('curso.show');

Route::get('nosotros', [NosotrosController::class, 'index'])->name('nosotros.index');

Route::get('noticias', [NoticiasController::class, 'index'])->name('noticias.index');

Route::get('Consultasunt', [ConsultasController::class, 'index'])->name('consultas.index');
Route::get('consultas/resolucion', [ConsultasController::class, 'resolucion'])->name('consultas.resolucion');


Route::get('docentes', [DocentesController::class, 'index'])->name('docentes.index');
Route::get('certificados/BuscarCertificado', [BuscarCertificadoController::class, 'BuscarCertificado'])->name('certificados.BuscarCertificado');

// Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
//     return view('admin.index');
// })->name('admin.home');
