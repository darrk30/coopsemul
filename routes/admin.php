<?php

use App\Http\Controllers\Admin\BibliotecaController;
use App\Http\Controllers\Admin\CategoriasController;
use App\Http\Controllers\Admin\ColaboradoresController;
use App\Http\Controllers\Admin\ContenidoController;
use App\Http\Controllers\Admin\CursoController;
use App\Http\Controllers\Admin\CursosController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InscripcionController;
use App\Http\Controllers\Admin\LeccionesController;
use App\Http\Controllers\Admin\MiBiblioteca;
use App\Http\Controllers\Admin\NivelesController;
use App\Http\Controllers\Admin\Precios;
use App\Http\Controllers\Admin\PreciosController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('', [HomeController::class, 'index'])->name('admin.home');


//Rutas para administrar los roles
Route::resource('roles', RoleController::class)->except('show')->names('admin.roles');

// rutas para los cursos de los profesores y alumnos
Route::resource('cursos', CursosController::class)->names('admin.cursos');
Route::delete('cursos/eliminar/{tipo}/{id}', [CursosController::class, 'eliminar'])->name('admin.cursos.eliminar_S_R');
Route::post('cursos/crear_recurso/{semana_id}', [CursosController::class, 'crear_recurso'])->name('admin.cursos.crear_recurso');
Route::post('cursos/descargar-recurso/{recursoId}', [CursosController::class, 'descargarRecurso'])->name('admin.cursos.descargar_recurso');
Route::get('cursos/recurso/formulario', [CursosController::class, 'formularioRecurso'])->name('admin.cursos.formulario');


// rutas para crear un curso

Route::resource('curso', CursoController::class)->names('admin.curso')->except(['destroy', 'show']);
Route::get('curso/buscarProfesor', [CursoController::class, 'BuscarProfesor'])->name('admin.curso.buscarProfesor');
Route::get('curso/{curso}/contenido', [CursoController::class, 'Contenido'])->name('admin.curso.contenido');
Route::get('curso/{curso}/students', [CursoController::class, 'Students'])->name('admin.curso.students');


//rutas para realizar inscripcion a alumnos
Route::resource('user', InscripcionController::class)->names('admin.matricula');
Route::get('matricula/{curso}/{user}/edit', [InscripcionController::class, 'editar'])->name('admin.matricula.editar');
Route::get('curso/{curso}/matricular', [InscripcionController::class, 'matricular'])->name('admin.matricular.crear');
Route::get('inscripcion/usuario/buscarDNI', [InscripcionController::class, 'buscarDNI'])->name('admin.matricular.buscarDNI');

//rutas para crud de biblioteca(ADMIN)
Route::resource('libros', BibliotecaController::class)->names('admin.libros');
Route::post('libros/descargar-libro/{LibroId}', [BibliotecaController::class, 'descargarLibro'])->name('admin.libros.descargar-libro');
Route::get('libros/abrir-archivo/{LibroId}', [BibliotecaController::class, 'abrirArchivo'])->name('admin.libros.abrir-archivo');


//rutas para biblioteca del usuario
Route::get('miBiblioteca', [MiBiblioteca::class, 'index'])->name('admin.miBiblioteca.index');
Route::get('miBiblioteca/show/{categoria}', [MiBiblioteca::class, 'show'])->name('admin.miBiblioteca.show');


//rutas para administrar trabajadores
Route::resource('users', ColaboradoresController::class)->names('admin.colaboradores');


//ruta para administrar el contenido del curso
Route::resource('contenidos', ContenidoController::class)->names('admin.contenidos');
Route::post('contenidos/modificar', [ContenidoController::class, 'modificar'])->name('admin.contenidos.modificar');

//ruta para administrar el contenido del curso
Route::resource('lecciones', LeccionesController::class)->names('admin.lecciones');
Route::post('lecciones/modificar', [LeccionesController::class, 'modificar'])->name('admin.lecciones.modificar');


//ruta para configurar precios
Route::resource('precios', PreciosController::class)->names('admin.precios');

//ruta para configurar categorias
Route::resource('categorias', CategoriasController::class)->names('admin.categorias');

//ruta para configurar categorias
Route::resource('niveles', NivelesController::class)->names('admin.niveles');