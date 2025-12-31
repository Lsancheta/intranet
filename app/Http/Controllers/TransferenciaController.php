<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transferencia;
use App\Models\Produto;
use App\Models\Local;
use App\Models\TipoTransferencia;
use App\Models\EstoqueItem;
use App\Models\DepositoItem;
use App\Models\Alojamento;
use App\Models\TransferenciaItem;
use App\Services\EstoqueService;
use Illuminate\Http\Request;
use Inertia\Inertia;

//regra de ouro -> TUDO que altera o banco de dados nessa operação precisa estar dentro do DB::Transaction!

class TransferenciaController extends Controller
{
    public function index()
    {
        return Inertia::render('Transferencias/Index', [
            'transferencias' => Transferencia::with([
                'tipo',
                'origem',
                'destino',
                'usuario',
                'itens.produto',
            ])
                ->orderBy('created_at', 'desc')
                ->paginate(15)
        ]);
    }

    public function create()
    {
        return Inertia::render('Transferencias/Create', [
            'produtos' => Produto::all(),
            'locais' => Local::all(),
            'alojamentos'=> Alojamento::all(),
            'tipos' => TipoTransferencia::all()
        ]);
    }

    public function store(Request $request, EstoqueService $estoqueService)
    {
        $validated = $request->validate([

            'tipo_id'          => 'required|exists:tipos_transferencia,id',
            'alojamento_id'    => 'required|exists:alojamentos,id',
            'local_origem_id'  => 'nullable|exists:locais,id',
            'local_destino_id' => 'nullable|exists:locais,id',
            'observacao'       => 'nullable|string|max:255',
            'itens'            => 'required|array|min:1',
            'itens.*.produto_id'       => 'required|exists:produtos,id',
            'itens.*.quantidade'       => 'required|numeric|min:0.001',
        ]);
        //----- Locais -----
        $origem = $validated['local_origem_id'] ? Local::find($validated['local_origem_id']) : null;
        $destino = $validated['local_destino_id'] ? Local::find($validated['local_destino_id']) : null;
        
        // buscar tipo
        $tipo = TipoTransferencia::findOrFail($validated['tipo_id']);
        
        //DB::Transaction -> o conceito desse método é como se fosse um contrato com o banco de dados, só vai acontecer determinada ação se TUDO o que foi estipulado realmente foi aplicado
        DB::transaction(function () use($validated, $tipo, $origem, $destino, $estoqueService){
           
            

            // 1 cria a transferencia
            $transferencia = Transferencia::create([
                'tipo_id' =>$validated['tipo_id'],
                'alojamento_id' =>$validated['alojamento_id'],
                'local_origem_id' => $validated['local_origem_id'] ?? null,
                'local_destino_id' => $validated['local_destino_id'] ?? null,
                'observacao' => $validated['observacao'] ?? null,
                'user_id' =>auth()->id(),
                'status_id' =>1
            ]);
            //2 foreach dos itens
            foreach ($validated['itens'] as $item){
                TransferenciaItem::create([
                    'transferencia_id' => $transferencia->id,
                    'produto_id' => $item['produto_id'],
                    'quantidade' => $item['quantidade'],
                ]);
            }
            //3 service de estoque
            $estoqueService->processar(
                $tipo,
                $origem,
                $destino,
                $validated['itens']
            );

            //4 cria itens 

            

            
        
            // ----Transferencia_itens----

        });

        return redirect()->back()->with('success', 'Movimentação registrada com sucesso.');
    }
}

    /* ============================================================
     * FUNÇÕES DE ESTOQUE / DEPÓSITO
     * ============================================================
     */

    //private function obterDepositoItem($produto_id, $local_id)
    //{
    //    return DepositoItem::firstOrCreate([
    //        'produto_id' => $produto_id,
    //        'local_id'   => $local_id
    //    ]);
    //}

    //private function obterEstoqueItem($produto_id, $local_id)
    //{
    //    return EstoqueItem::firstOrCreate([
    //        'produto_id' => $produto_id,
    //        'local_id'   => $local_id
    //    ]);
    //}

    //private function validarDeposito($produto_id, $local_id, $quantidade)
    //{
    //    $item = $this->obterDepositoItem($produto_id, $local_id);

    //    if ($item->quantidade < $quantidade) {
    //        abort(400, "Quantidade indisponível no depósito.");
    //    }
    //}

    //private function validarEstoque($produto_id, $local_id, $quantidade)
    //{
    //    $item = $this->obterEstoqueItem($produto_id, $local_id);

    //    if ($item->quantidade < $quantidade) {
    //        abort(400, "Quantidade indisponível no estoque.");
    //    }
    //}

    //private function incrementarDeposito($produto_id, $local_id, $quantidade)
    //{
    //    $item = $this->obterDepositoItem($produto_id, $local_id);
    //    $item->increment('quantidade', $quantidade);
    //}

    //private function decrementarDeposito($produto_id, $local_id, $quantidade)
    //{
    //    $item = $this->obterDepositoItem($produto_id, $local_id);
    //    $item->decrement('quantidade', $quantidade);
    //}

    //private function incrementarEstoque($produto_id, $local_id, $quantidade)
    //{
    //    $item = $this->obterEstoqueItem($produto_id, $local_id);
    //    $item->increment('quantidade', $quantidade);
    //}

    //private function decrementarEstoque($produto_id, $local_id, $quantidade)
    //{
    //    $item = $this->obterEstoqueItem($produto_id, $local_id);
    //    $item->decrement('quantidade', $quantidade);
    //}

    //private function ajustarLocal($produto_id, $local_id, $quantidade)
    //{
    //    $local = Local::findOrFail($local_id);

    //    if ($local->tipo === 'deposito') {
    //        $item = $this->obterDepositoItem($produto_id, $local_id);
    //    } else {
    //        $item = $this->obterEstoqueItem($produto_id, $local_id);
    //    }

    //    $item->quantidade = $quantidade;
    //    $item->save();
    //}

