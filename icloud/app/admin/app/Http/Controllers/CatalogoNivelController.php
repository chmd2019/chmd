<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Catalogo_nivel;

class CatalogoNivelController extends Controller {
	public function index(Request $req)
	{
		$niveles = DB::table('Catalogo_nivel')
		->orderBy('id','desc')
		->paginate(15);
		return view('catalogos.nivel.index', ['niveles' => $niveles]);

	}


	public function store(Request $req){
	  $name = $req->input('nombre');
       DB::table('Catalogo_nivel')->insert(
		['nivel' => $name]
	);
	 
	return redirect('nivel');
	}
	
	public function edit($id){
		$nivel = Catalogo_nivel::findOrFail($id);
		return view('catalogos.nivel.edit',compact('nivel'));		
	}

	public function update(Request $req,$id){
		$name = $req->input('nombre');
		DB::table('Catalogo_nivel')->where('id',$id)->update(
		 ['nivel' => $name]);

		 return redirect('nivel');
	}


	public function create(){
		return view('catalogos.nivel.create');		
	}

	public function destroy($id){
		DB::table('Catalogo_nivel')->where('id',$id)->delete();
		return redirect('nivel');		
	}

	

}