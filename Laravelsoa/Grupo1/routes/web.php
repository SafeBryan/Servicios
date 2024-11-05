<?php

use Illuminate\Support\Facades\Route;
// Importar el EstudianteController
use App\Http\Controllers\EstudianteController;

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

Route::get('/', function () {
    return view('welcome');
});
// En el url despues de public poner "/estudiantes y ahi ya esta"
Route::get('estudiantes', [EstudianteController::class,'index']);
Route::get('estudiantes/create', [EstudianteController::class,'create']);
Route::get('estudiantes/{cedula}', [EstudianteController::class,'show']);
Route::post('estudiantes', [EstudianteController::class,'store']);
Route::get('estudiantes/{cedula}/edit', [EstudianteController::class,'edit']);
Route::put('estudiantes/{cedula}', [EstudianteController::class,'update']);
Route::DELETE('estudiantes/{cedula}', [EstudianteController::class,'destroy']);

//Route::resource('estudiantes',EstudianteController::class);
