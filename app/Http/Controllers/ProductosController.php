<?php
namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Http\Requests;

use App\Models\Producto;

class ProductosController extends Controller
{
    public function index() {
        $productos = Producto::where('estado', 1)->orderBy("nombre")->get();
	    
	    return $productos;
    }
    
      
    public function store(Request $request) {
        try {
            if(!$request->has('nombre') || !$request->has('precio')){
                throw new \Exception('Se esperaba campos mandatorios');
            }
            
            $producto = new Producto();
            $producto->nombre = $request->get('nombre');
    		$producto->precio = $request->get('precio');
    		$producto->detalles = $request->get('detalles');
    		
    		if($request->hasFile('imagen') && $request->file('imagen')->isValid())
    		{
        		$imagen = $request->file('imagen');
        		$filename = $request->file('imagen')->getClientOriginalName();
        		
        		Storage::disk('images')->put($filename,  File::get($imagen));
        		
        		$producto->imagen = $filename;
    		}
    		
    		$producto->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function destroy($id){
        try
        {
            $producto = Producto::find($id);
            
            if($producto == null)
                throw new \Exception('Registro no encontrado');
    		
    		if(Storage::disk('images')->exists($producto->imagen))
    		    Storage::disk('images')->delete($producto->imagen);
    		
    		$producto->delete();
    		
            return response()->json(['type' => 'success', 'message' => 'Registro eliminado'], 200);
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function show($id){
        try
        {
            $producto = Producto::find($id);
            
            if($producto == null)
                throw new \Exception('Registro no encontrado');
    		
            return $producto;
    	    
        }catch(\Exception $e)
        {
            return response()->json(['type' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


}
