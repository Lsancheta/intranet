<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OrdemServico;


class OsController extends Controller
{
    
    public function index(Request $request){

        //filtro de pesquisa via query string GET
        $query = OrdemServico::query()->with('solicitante','prioridade','status','bloco','quarto','alojamento');
        
        //filtro por setor (alojamento/bloco)
        if ($request ->filled('setor')){
            $query->where('bloco_id', $request->setor);
        }

        //filtro por solicitante
        if($request->filled('solicitante')){
            $query->where('solicitante_id', $request->solicitante);
        }

        // filtro por texto(titulo e descrição)
        if ($request->filled('texto')){
            $texto = $request->texto;
            $query->where(function($q) use ($texto){
                $q->where('titulo','LIKE', "%$texto%")
                ->orwhere('descricao', 'LIKE', "%$texto%");
            });
        }

        //filtro por status
        if($request->filled('status')){
            $query->where('status_id', $request->status);
        }

        //filtro por prioridade
        if($request->filled('prioridade')){
            $query->where('prioridade_id', $request->prioridade);
        }

        //paginação
        $ordens = $query->orderBy('created_at', 'desc')->paginate(20);

        //SLA de 3 dias 
        \App\Models\OrdemServico::where('status_id','!=', 4) // ignorar OS resolvidas
        ->where('status_id','!=', 3) // ignorar já pendentes
        ->whereDate('created_at','<',now()->subDays(3))
        ->update(['status_id'=>3]); // vai mudar para pendentes aquelas que passarem dos dias

        $ordens = OrdemServico::with('solicitante', 'prioridade', 'status', 'alojamento', 'bloco', 'quarto')
            ->join('prioridades', 'ordens_servico.prioridade_id', '=', 'prioridades.id')
            ->where('ordens_servico.status_id','!=', 4)
            ->orderByRaw("
                CASE 
                    WHEN prioridades.nome = 'Alta' THEN 1
                    WHEN prioridades.nome = 'Média' THEN 2
                    ELSE 3
                END
            ")
            ->orderByDesc('ordens_servico.created_at')
            ->select('ordens_servico.*')
            ->get();

        $alojamentos = \App\Models\Alojamento::with('blocos.quartos')->get();
        $prioridades = \App\Models\Prioridade::all();
        return Inertia::render('Ordens/Index',[
            'ordens'=> $ordens,
            'alojamentos'=>$alojamentos,
            'prioridades'=>$prioridades,
            'filtros'=>$request->only('setor','solicitante','texto','status','prioridade'),
        ]);


    }

    public function create(){
        return Inertia::render('Ordens/Create',[
            'prioridades'=> \App\Models\Prioridade::all(),
            'alojamentos'=>\App\Models\Alojamento::with('blocos.quartos')->get()
        ]);
    }

    public function store(Request $request){
        //dd($request->all());
        $data = $request->validate([
            'titulo' =>'required|string|max:255',
            'descricao'=>'required|string',
            'prioridade_id'=>'required|exists:prioridades,id',
            'alojamento_id'=>'required|exists:alojamentos,id',
            'bloco_id'=>'required|exists:blocos,id',
            'quarto_id'=>'nullable|exists:quartos,id',
            'fotos.*'=> 'image|mimes:jpg,jpeg,png|max:2048'
        ]);
        OrdemServico::create(array_merge($data,[
            'solicitante_id'=> auth()->id(),
            'status_id'=>1, //Isso irá forçar a criação da OS em aberta de acordo com o BD.
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
        $alojamentos = \App\Models\Alojamento::with('blocos.quartos')->get();
        $prioridades = \App\Models\Prioridade::all();        
        $ordem = OrdemServico::with(
            'solicitante',
            'status',
            'prioridade',
            'bloco',
            'quarto',
            'comentarios.user',
            'fotos',
        )->findOrFail($id);
        // Se não estiver concluída (STATUS 4) e não estiver pendente ainda (STATUS 3)
        if ($ordem->status_id !== 4 && $ordem->status_id !== 3) {

            $dias = $ordem->created_at->diffInDays(now());

            // Se passaram 3 dias e o status ainda NÃO é em andamento
            if ($dias >= 3 && $ordem->status_id !== 2) {
                //atualiza o status
                $ordem->update([
                'status_id' => 3 // pendente
                ]);
                $ordem->load('status');
            }
        }
        return Inertia::render('Ordens/Show', [
            'ordem' => $ordem,
            'prioridades'=> \App\Models\Prioridade::all(),
            'alojamentos'=>\App\Models\Alojamento::with('blocos.quartos')->get()
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
        $ordem = \App\Models\OrdemServico::findOrFail($id);

        //adicionar comentario
        \App\Models\ComentarioOs::create([
            'ordem_servico_id'=> $id,
            'user_id'=> auth()->id(),
            'comentario'=> $request->comentario,
        ]);

        if($ordem->status_id === 1){
            $ordem->update(['status_id'=> 2]);
        }

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

    //finalizar OS
    public function finalizarOs(Request $request, $id){
        $request->validate([
            'comentario'=>'required|string|max:2000'
        ]);
        $ordem = OrdemServico::findOrFail($id);

        // registrar o ultimo comentario para finalizar os
        \App\Models\ComentarioOs::create([
            'ordem_servico_id'=>$ordem->id,
            'user_id'=>auth()->id(),
            'comentario'=>$request->comentario,
        ]);

        // mudar a OS para resolvida id 4 no BD
        $ordem->update(['status_id' => 4]);

        return redirect()
            ->route('ordens.index')->with('success','OS Concluída com Sucesso!');
    }

    //listar OS finalizadas
    public function finalizadas(){
        $ordens = OrdemServico::with('solicitante','prioridade','status')
        ->where('status_id', 4)
        ->orderBy('created_at', 'desc')
        ->get();

        return Inertia::render('Ordens/Finalizadas',[
            'ordens'=> $ordens
        ]);
    }
}