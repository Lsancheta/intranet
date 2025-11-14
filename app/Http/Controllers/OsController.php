<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdemServico;


class OsController extends Controller
{
    
    public function index(){
        $ordens = OrdemServico::with('solicitante')->orderByDesc('created_at')->get();
        return Inertia::render('Ordens/Index',[
            'ordens'=> $ordens
        ]);
    }

    public function create(){
        return Inertia::render('Ordens/Create');
    }
    public function store(Request $request){
        
        $data = $request->validate([
            'titulo' =>'required|string|max:255',
            'descricao'=>'required|string',
            'status'=>'required|string',
            'prioridade'=>'nullable|string',
        ]);
        OrdemServico::create(array_merge($data,[
            'solicitante_id'=> auth()->id(),
        ]));
        return redirect()->route('ordens.index')->with('Success', 'OS Criada com sucesso!');
    }

    public function show($id){

        $ordem = OrdemServico::with('solicitante')->findOrFail($id);

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
}