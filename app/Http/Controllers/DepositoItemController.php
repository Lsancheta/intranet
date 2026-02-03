<?php

namespace App\Http\Controllers;

use App\Models\DepositoItem;
use Illuminate\Http\Request;

class DepositoItemController extends Controller
{
    /**
     * Lista os itens do depósito.
     */
    public function index()
    {
        $itens = DepositoItem::with(['produto', 'deposito'])->paginate(20);

        return inertia('Deposito/Itens/Index', [
            'itens' => $itens,
        ]);
    }

    /**
     * Formulário de criação.
     */
    public function create()
    {
        return inertia('Deposito/Itens/Create');
    }

    /**
     * Salva um item no depósito.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'deposito_id' => 'required|exists:depositos,id',
            'quantidade' => 'required|numeric|min:0',
            'descricao' => 'nullable|string|max:255',
        ]);

        DepositoItem::create($validated);

        return redirect()->route('deposito-itens.index')
            ->with('success', 'Item adicionado ao depósito!');
    }

    /**
     * Formulário de edição
     */
    public function edit(DepositoItem $depositoItem)
    {
        return inertia('Deposito/Itens/Edit', [
            'item' => $depositoItem,
        ]);
    }

    /**
     * Atualiza o item do depósito.
     */
    public function update(Request $request, DepositoItem $depositoItem)
    {
        $validated = $request->validate([
            'quantidade' => 'required|numeric|min:0',
            'descricao' => 'nullable|string|max:255',
        ]);

        $depositoItem->update($validated);

        return redirect()->route('deposito-itens.index')
            ->with('success', 'Item atualizado!');
    }

    /**
     * Remove o item do depósito.
     */
    public function destroy(DepositoItem $depositoItem)
    {
        $depositoItem->delete();

        return redirect()->route('deposito-itens.index')
            ->with('success', 'Item removido do depósito!');
    }
}
