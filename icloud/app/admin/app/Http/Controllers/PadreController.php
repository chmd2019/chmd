<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Padre;

class PadreController extends Controller {
	public function index(Request $req)
	{
		$padres = DB::table('App_papa')
		->orderBy('apellidos','asc')
		->paginate(15);

		return view('catalogos.padre.index', ['padres' => $padres]);
	}

	public function search(Request $req){
		$q = $req->input('q');
		$padres = DB::table('App_papa')
		->where('nombre',"like",'%'.$q.'%')
		->orWhere('apellidos',"like",'%'.$q.'%')
		->orWhere('correo',"like",'%'.$q.'%')
		->get()
		->toArray();
			return view('catalogos.padre.buscar', ['padres' => $padres]);
	}
	

}