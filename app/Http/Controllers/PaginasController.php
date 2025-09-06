<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use App\Mail\ContactoMensaje;
use Illuminate\Support\Facades\Mail;

class PaginasController extends Controller
{
    public function index()
    {
        $propiedades = Property::inRandomOrder()->limit(3)->get();
        return view('paginas.index', [
            'propiedades' => $propiedades,
            'inicio' => true
        ]);
    }

    public function nosotros()
    {
        return view('paginas.nosotros', [
            'inicio' => false
        ]);
    }

    public function propiedades()
    {
        $propiedades = Property::all();
        return view('paginas.propiedades', [
            'propiedades' => $propiedades,
            'inicio' => false
        ]);
    }

    public function propiedad(Property $propiedad)
    {
        return view('paginas.propiedad', [
            'propiedad' => $propiedad,
            'inicio' => false
        ]);
    }

    public function blog()
    {
        return view('paginas.blog', [
            'inicio' => false
        ]);
    }

    public function entrada()
    {
        return view('paginas.entrada', [
            'inicio' => false
        ]);
    }

    public function contacto(Request $request)
    {

        if ($request->isMethod('POST')) {
            $validated = $request->validate([
                'contacto.nombre' => 'required|string|max:50',
                'contacto.mensaje' => 'required|string',
                'contacto.tipo' => 'required|in:Compra,Vende',
                'contacto.precio' => 'required|numeric|min:1',
                'contacto.contacto' => 'required|in:telefono,email',
                'contacto.telefono' => 'required_if:contacto.contacto,telefono',
                'contacto.email' => 'required_if:contacto.contacto,email|email',
                'contacto.fecha' => 'required_if:contacto.contacto,telefono|date',
                'contacto.hora' => 'required_if:contacto.contacto,telefono'
            ]);

            try {
                $contenido = "Nuevo mensaje de contacto:\n\n";
                $contenido .= "Nombre: {$validated['contacto']['nombre']}\n";
                $contenido .= "Mensaje: {$validated['contacto']['mensaje']}\n";
                $contenido .= "Tipo: {$validated['contacto']['tipo']}\n";
                $contenido .= "Presupuesto: Q.{$validated['contacto']['precio']}\n";
                
                if ($validated['contacto']['contacto'] === 'telefono') {
                    $contenido .= "\nContacto por teléfono:\n";
                    $contenido .= "Teléfono: {$validated['contacto']['telefono']}\n";
                    $contenido .= "Fecha: {$validated['contacto']['fecha']}\n";
                    $contenido .= "Hora: {$validated['contacto']['hora']}\n";
                } else {
                    $contenido .= "\nContacto por email:\n";
                    $contenido .= "Email: {$validated['contacto']['email']}\n";
                }

                // Enviar correo directamente a Mailhog
                Mail::raw($contenido, function($message) {
                    $message->to('admin@bienesraices.com')
                        ->subject('Nuevo mensaje de contacto');
                });

                return back()->with('mensaje', 'Mensaje enviado correctamente');
            } catch (\Exception $e) {
                return back()->with('error', 'Error al enviar el mensaje');
            }
        }

        return view('paginas.contacto', [
            'inicio' => false,
            'mensaje' => session('mensaje'),
            'error' => session('error')
        ]);
    }
}
