<?php

use App\Http\Controllers\CursosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\NoticiasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('Home');

Route::get('cursos', [CursosController::class, 'index'])->name('curso.index');
Route::get('curso/{curso}', [CursosController::class, 'show'])->name('curso.show');

Route::get('nosotros', [NosotrosController::class, 'index'])->name('nosotros.index');

Route::get('noticias', [NoticiasController::class, 'index'])->name('noticias.index');

// Route::middleware(['auth:sanctum', 'verified'])->get('/admin', function () {
//     return view('admin.index');
// })->name('admin.home');
