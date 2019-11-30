<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Circular;

class CircularController extends Controller {
	public function index(Request $req)
	{
		$circulares = DB::table('App_circulares')
		->orderBy('id','desc')
		->paginate(15);

		return view('catalogos.circulares.index', ['circulares' => $circulares]);
	}


	public function create(){
		$niveles = DB::table('Catalogo_nivel')->get()->toArray();
		$grados = DB::table('catalogo_grado_cursar')->get()->toArray();
		$grupos = DB::table('catalago_grupos_cch')->get()->toArray();
		$grupos_esp = DB::table('App_grupos_especiales')->get()->toArray();
		$grupos_admin = DB::table('App_grupos_administrativos')->get()->toArray();
		return view('catalogos.circulares.create',compact('niveles','grados','grupos','grupos_esp','grupos_admin'));
	}



	public function search(Request $req){
		$q = $req->input('q');

		$circulares = DB::table('App_circulares')
		->where('titulo',"like",'%'.$q.'%')
		->orWhere('contenido',"like",'%'.$q.'%')
		->get()
		->toArray();
		return view('catalogos.circulares.buscar', ['circulares' => $circulares]);
	}



	public function store(Request $req){
		/*$this->validate($req,['titulo'=>'required']);
		Circular::create($req->all());
		return redirect()->route('catalogos.circulares.index')->with('success','Circular creada correctamente');
		*/
		$this->validate($req,['titulo'=>'required']);
		$titulo = $req->input('titulo');
		$contenido = $req->input('contenido');
		$ciclo = $req->input('ciclo_escolar_id');
		$adjunto = $req->input('cboAdjunto');
		$estatus = $req->input('cboEstatus');
		DB::table('App_circulares')->insert(
		 ['titulo' => $titulo,
		 'contenido' => $contenido,
		 'ciclo_escolar_id' => $ciclo,
		 'adjunto' => $adjunto,
		 'estatus' => $estatus
		 ]

		);
	 
		return redirect('circulares')->with('success','Circular creada correctamente');
		}
	
	public function show($id){
		$circular = Circular::find($id);
		return view('catalogos.circulares.show',compact('circular'));
	}

	public function edit($id){
		$niveles = DB::table('Catalogo_nivel')->get()->toArray();
		$grados = DB::table('catalogo_grado_cursar')->get()->toArray();
		$grupos = DB::table('catalago_grupos_cch')->get()->toArray();
		$grupos_esp = DB::table('App_grupos_especiales')->get()->toArray();
		$grupos_admin = DB::table('App_grupos_administrativos')->get()->toArray();
		$circular = Circular::findOrFail($id);
		return view('catalogos.circulares.edit',compact('circular','niveles','grados','grupos','grupos_esp','grupos_admin'));		
	}

	public function update(Request $req, $id){
		//$circular = Circulares::find($id)->update($req->all());
		
		$this->validate($req,['titulo'=>'required']);
		$titulo = $req->input('titulo');
		$contenido = $req->input('contenido');
		$ciclo = $req->input('ciclo_escolar_id');
		$adjunto = $req->input('cboAdjunto');
		$estatus = $req->input('cboEstatus');
		DB::table('App_circulares')
		->where('id',$id)
		->update(
		 ['titulo' => $titulo,
		 'contenido' => $contenido,
		 'ciclo_escolar_id' => $ciclo,
		 'adjunto' => $adjunto,
		 'estatus' => $estatus
		 ]

		);
		
		

		return redirect('circulares');

		
	}

	public function delete($id){
		$circular = Circulares::find($id)->delete();
		return redirect('circulares');
	}

}