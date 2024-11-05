<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// AGREGAR ESTA IMPORTACION
use Illuminate\Support\Facades\Http;

class EstudianteController extends Controller{
    protected static $url = "http://localhost/Servicios/Soa/controllers/apiRest.php";
    public function index(){
        $estudiantes = Http::GET(static::$url);
        $estudiantesArray = $estudiantes->json();
        return view('estudinatesInicio', compact('estudiantesArray'));
    }

    // Show the form for creating a new resource
    public function create(){
        return view('crearEstudiante');
    }

    // Store a newly created resource in storage
    public function store(Request $request){
        $response = Http::asForm()->post(static::$url, [
            'cedula' => $request->input('cedula'),
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono')
        ]);

        return redirect('/estudiantes');
    }

    // Display the specified resource
    public function show(string $cedula){
        $estudiantes = Http::GET(static::$url . "?cedula=" . $cedula);
        $estudiantesArray = $estudiantes->json();
        return view('estudinatesInicio', compact('estudiantesArray'));
    }

    // Show the form for editing the specified resource
    public function edit(string $cedula){
        $estudiantes = Http::get(static::$url)->json();

        $estudiante = collect($estudiantes)->firstWhere('cedula', $cedula);

        return view('edit', with(['estudiante' => $estudiante]));
    }

    // Update the specified resource in storage.
    public function update(Request $request){
        $cedula = $request->input('cedula');
        $nombre = $request->input('nombre');
        $apellido = $request->input('apellido');
        $direccion = $request->input('direccion');
        $telefono = $request->input('telefono');

        // Datos que quieres enviar en la solicitud PUT
        $data = [
            'cedula' => $cedula,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'direccion' => $direccion,
            'telefono' => $telefono,
        ];
        $response = Http::asForm()->put(static::$url, $data);
        return redirect('/estudiantes');
    }


    // Remove the specified resource from storage
    public function destroy(string $cedula){
        $response = Http::delete(static::$url . "?cedula=" . $cedula);

        // Redirigimos a la página de listado de estudiantes
        return redirect('/estudiantes');
    }
}
