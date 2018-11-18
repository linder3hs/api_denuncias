<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Usuario;

class ApiController extends Controller
{
    
    public function login(Request $request) {
        $credentials = $request->only('username', 'password');
        
        if (Auth::once($credentials)) {
         $user = Auth::user();
         
         return $user;
        }
        return response()->json(['error' => 'Usuario y/o clave inválido'], 401); 
    }
    
    public function loginUser() {
        
        $user = Usuario::get();
	    
	    return $user;
       
    }
    
     //Registro de Usuario
    public function registerUser(Request $request){
        try{
            if(!$request->has('username') || !$request->has('correo') || !$request->has('password') ){
                throw new \Exception('Campos mandatorios');
            }
            
            $usuario = new Usuario();
            $usuario->username = $request->get('username');
    		$usuario->correo = $request->get('correo');
    		$usuario->password = bcrypt($request->get('password'));

    		$usuario->save();
    	    
    	    return response()->json(['type' => 'success', 'message' => 'Registro completo'], 200);
    	    
        }catch(\Exception $e){
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
}
