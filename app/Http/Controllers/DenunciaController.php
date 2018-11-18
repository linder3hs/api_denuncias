<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Denuncia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;


class DenunciaController extends Controller
{
        public function index(){
        $denuncias = Denuncia::get();
	    return $denuncias;
        }
        
        public function store(Request $request) {
        try {
            
          /*  if($request->has('titulo'))
            {
            throw new \Exception('Se esperaba campos mandatorios');

            }*/
            /*if($request->has('titulo')){
                throw new \Exception('Se esperaba campos mandatorios');
            }*/
            
            $denuncia = new Denuncia();
            $denuncia->titulo = $request->get('titulo');
    		$denuncia->descripcion = $request->get('descripcion');
    		$denuncia->ubicacion = $request->get('ubicacion');
    		$denuncia->lat = $request->get('lat');
    		$denuncia->lng = $request->get('lng');

    		$denuncia->user_id = $request->get('user_id');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())	{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$denuncia->imagen = $filename;
    		}
    		
    		
    		$denuncia->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Denunca Completa'], 200);
    	    
        }catch(\Exception $e) {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
     
    }
    
     public function show($idd){
        try
        {
            $denuncia = Denuncia::find($idd);
            
            if($denuncia == null)
                throw new \Exception('Registro no encontrado');
    		
            return $denuncia;
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
        
      
}
