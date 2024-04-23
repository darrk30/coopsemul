<?php

use App\Http\Controllers\Admin\BibliotecaController;
use App\Http\Controllers\Admin\CategoriasController;
use App\Http\Controllers\Admin\CiclosController;
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




// rutas para crear un curso

Route::resource('curso', CursoController::class)->names('admin.curso')->except(['destroy', 'show']);
Route::get('curso/buscarProfesor', [CursoController::class, 'BuscarProfesor'])->name('admin.curso.buscarProfesor');
Route::get('curso/{curso}/contenido', [CursoController::class, 'Contenido'])->name('admin.curso.contenido');



//rutas para realizar inscripcion a alumnos
Route::resource('user', InscripcionController::class)->names('admin.matricula');
Route::get('matricula/{ciclo}/{user}/edit', [InscripcionController::class, 'editar'])->name('admin.matricula.editar');
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
Route::resource('contenidos', ContenidoController::class)->names('admin.contenidos')->except(['create','update','index','destroy', 'show', 'edit']);
Route::post('contenidos/modificar', [ContenidoController::class, 'modificar'])->name('admin.contenidos.modificar');
Route::post('contenidos/eliminar', [ContenidoController::class, 'eliminar'])->name('admin.contenidos.eliminar');

//ruta para administrar el contenido del curso
Route::resource('lecciones', LeccionesController::class)->names('admin.lecciones')->except(['create','update','index','destroy', 'show', 'edit']);
Route::post('lecciones/modificar', [LeccionesController::class, 'modificar'])->name('admin.lecciones.modificar');
Route::post('lecciones/eliminar', [LeccionesController::class, 'eliminar'])->name('admin.lecciones.eliminar');


//ruta para configurar precios
Route::resource('precios', PreciosController::class)->names('admin.precios')->except(['show']);

//ruta para configurar categorias
Route::resource('categorias', CategoriasController::class)->names('admin.categorias')->except(['show']);

//ruta para configurar categorias
Route::resource('niveles', NivelesController::class)->names('admin.niveles')->except(['show']);


//administrar ciclos
Route::resource('ciclos', CiclosController::class)->names('admin.ciclos')->except(['destroy']);

Route::get('matriculados/{ciclo}/students', [CiclosController::class, 'Students'])->name('admin.ciclos.students');
Route::get('ciclos/{ciclo}/matricular', [InscripcionController::class, 'matricular'])->name('admin.matricular.crear');
Route::post('ciclos/agregarSemana', [CiclosController::class, 'agregarSemana'])->name('admin.ciclos.agregarSemana');

Route::get('ciclos/recurso/formulario', [CiclosController::class, 'formularioRecurso'])->name('admin.ciclos.formulario');

Route::delete('ciclos/eliminar/{tipo}/{id}', [CiclosController::class, 'eliminar'])->name('admin.ciclos.eliminar_S_R');

Route::post('ciclos/crear_recurso/{semana_id}/{curso_nombre}/{ciclo_nombre}', [CiclosController::class, 'crear_recurso'])->name('admin.ciclos.crear_recurso');

Route::post('ciclos/descargar-recurso/{recursoId}', [CiclosController::class, 'descargar_recurso'])->name('admin.ciclos.descargar-recurso');

Route::get('ciclos/abrir-archivo/{recursoId}', [CiclosController::class, 'abrirArchivo'])->name('admin.ciclos.abrir-archivo');

