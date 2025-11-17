<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdemServico;


class OsController extends Controller
{
    
    public function index(){
        $ordens = OrdemServico::with('solicitante')->orderByDesc('created_at')->get();
        $alojamentos = \App\Models\Alojamento::with('blocos.quartos')->get();
        return Inertia::render('Ordens/Index',[
            'ordens'=> $ordens,
            'alojamentos'=>$alojamentos,
        ]);
    }

    public function create(){
        return Inertia::render('Ordens/Create');
    }
    public function store(Request $request){
        //dd($request->all());
        $data = $request->validate([
            'titulo' =>'required|string|max:255',
            'descricao'=>'required|string',
            'prioridade'=>'required|string',
            'alojamento_id'=>'required|exists:alojamentos,id',
            'bloco_id'=>'required|exists:blocos,id',
            'quarto_id'=>'required|exists:quartos,id',
            'fotos.*'=> 'image|mimes:jpg,jpeg,png|max:2048'
        ]);
        OrdemServico::create(array_merge($data,[
            'solicitante_id'=> auth()->id(),
            'status'=>'Aberta', //Isso irá forçar a criação da OS em aberta.
        ]));
        //salvar imagem
        if ($request-> hasFile('fotos')){
            foreach($request->file('fotos') as $foto){
                $path = $foto->store('os_fotos', 'public');
                \App\Models\OsFoto::create([
                    'ordem_servico_id'=> $ordem->id,
                    'caminho'=>$path
                ]);
            }
        }
        return redirect()->route('ordens.index')->with('Success', 'OS Criada com sucesso!');
    }

    public function show($id){

        $ordem = OrdemServico::with(
            'solicitante',
            'comentarios.user',
            'fotos'
            )->findOrFail($id);

        return Inertia::render('Ordens/Show',[
            'ordem'=>$ordem
        ]);
    }

    public function edit($id){
        $ordem = OrdemServico::findOrFail($id);

        return view('ordem-servico.edit',[
            'ordem'=>$ordem
        ]);
    }

    public function update(Request $request, $id){
        // logica para update
        $ordem = OrdemServico::findOrFail($id);

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'status' => 'required|string',
            'prioridade' => 'nullable|string',
        ]);

        $ordem ->update($data);

        return redirect()->route('ordens.index')->with('success','OS atualizada com sucesso!');
    }

    public function destroy($id){
        //lógica para delete
        $ordem = OrdemServico::findOrFail($id);
        $ordem->delete();

        return redirect()->rout('ordens.index')->with('sucess','OS Excluída com Sucesso');
    }

    //Adicionar comentario
    public function adicionarComentario(Request $request, $id){

        $request->validate([
            'comentario'=>'required|string|max:2000'
        ]);

        if (!auth()->check()){
            abort(403, "Usuário não autenticado");
        }

        \App\Models\ComentarioOs::create([
            'ordem_servico_id'=> $id,
            'user_id'=> auth()->id(),
            'comentario'=> $request->comentario,
        ]);

        return back()->with('success','Comentário adicionado!');
    }

    //Adicionar foto
    public function adicionarFoto(Request $request, $id){
        $request->validate([
            'foto'=>'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $ordem = OrdemServico::findOrFail($id);
        $path = $request->file('foto')->store('os_fotos', 'public');

        \App\Models\OsFoto::create([
            'ordem_servico_id' => $ordem->id,
            'caminho'=>$path
        ]);
        return back()->with('success','Foto adicionada!');
    }
}