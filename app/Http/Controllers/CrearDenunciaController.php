<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;

use App\Http\Requests;

class CrearDenunciaController extends Controller
{
     public function store(Request $request) {
        try {
            
          /*  if($request->has('titulo'))
            {
            throw new \Exception('Se esperaba campos mandatorios');

            }*/
            $denuncia = new Denuncia();
            $denuncia->titulo = $request->get('titulo');
    		$denuncia->descripcion = $request->get('descripcion');
    		$denuncia->ubicacion = $request->get('ubicacion');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())	{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$producto->imagen = $filename;
    		}
    		
    		$denuncia->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Denunca Completa'], 200);
    	    
        }catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
     
    }
}
