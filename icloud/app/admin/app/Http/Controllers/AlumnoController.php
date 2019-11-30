<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Alumno;

class AlumnoController extends Controller {
	public function index(Request $req)
	{
		$alumnos = DB::table('alumnoschmd')->paginate(15);
		return view('catalogos.alumno.index', ['alumnos' => $alumnos]);
	}

public function search(Request $req){
	$q = $req->input('q');
	$alumnos = DB::table('alumnoschmd')
	->where('nombre',"like",'%'.$q.'%')
	->orWhere('grado',"like",'%'.$q.'%')
	->orWhere('grupo',"like",'%'.$q.'%')
	->get()
	->toArray();
		return view('catalogos.alumno.buscar', ['alumnos' => $alumnos]);
}

}