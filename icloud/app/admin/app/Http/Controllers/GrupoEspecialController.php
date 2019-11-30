<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\GrupoEspecial;

class GrupoEspecialController extends Controller {
	
	public function index()
	{
		$grupoEspecial = DB::table("App_grupos_especiales")
		->orderBy('id','desc')
		->paginate(15);
		return view('catalogos.gruposEspeciales.index', ['grupoEspecial' => $grupoEspecial]);
    }
    
    public function create(Request $req)
	{
        return view('catalogos.gruposEspeciales.create');		
	}
	public function store(Request $req){
		$nombre = $req->input('nombre');
		$descripcion = $req->input('descripcion');
		DB::table('App_grupos_especiales')->insert(
			['grupo' => $nombre,'descripcion' => $descripcion]);
			return redirect('gruposEspeciales');
    }
    

    public function edit($id){
		$grupoEspecial = GrupoEspecial::findOrFail($id);
		return view('catalogos.gruposEspeciales.edit',compact('grupoEspecial'));		
	}
	public function update(Request $req, $id){
		$grupo = $req->input('nombre');
		$descripcion = $req->input('descripcion');
		DB::table('App_grupos_especiales')->where('id',$id)->update(
			['grupo' => $grupo,'descripcion' => $descripcion]);
			return redirect('gruposEspeciales');
	}


    public function asociar($id){
        $grupoEspecial = GrupoEspecial::findOrFail($id);
        $alumnos = DB::table('alumnoschmd')->get()->toArray();
        
        //Mostrar listado de alumnos asociados a este grupo
        $alumnosAsociados = DB::table("vwAlumnosGruposEspeciales")
		->orderBy('alumno_id','desc')
		->where('grupoEspecial',$id)
        ->paginate(15);
        
        return view('catalogos.gruposEspeciales.asociar',compact('grupoEspecial','alumnos','alumnosAsociados'));	
        
        

	}



    public function asoc(Request $req, $idGrupo)
	{
        $idAlumno = $req->input('cboAlumnos'); 
		DB::table('App_grupos_especiales_alumnos')->insert(
            ['alumno_id' => $idAlumno,'grupo_id' => $idGrupo]);
            

            $grupoEspecial = GrupoEspecial::findOrFail($idGrupo);
            $alumnos = DB::table('alumnoschmd')->get()->toArray();
            
            //Mostrar listado de alumnos asociados a este grupo
            $alumnosAsociados = DB::table("vwAlumnosGruposEspeciales")
            ->orderBy('alumno_id','desc')
            ->paginate(15);

			return view('catalogos.gruposEspeciales.asociar',compact('grupoEspecial','alumnos','alumnosAsociados'));	
        
    }


    public function deasoc($id)
	{
        DB::table('App_grupos_especiales_alumnos')
        ->where('id',$id)
        ->delete();
            return redirect('gruposEspeciales');
            
    }

    public function destroy($id)
	{
		DB::table('App_grupos_especiales')->where
        ('id',$id)->delete();
			return redirect('gruposEspeciales');
    }

}

?>