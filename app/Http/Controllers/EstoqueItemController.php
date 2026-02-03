<?php

namespace App\Http\Controllers;

use App\Models\EstoqueItem;
use Illuminate\Http\Request;

class EstoqueItemController extends Controller
{
    /**
     * Lista todos os itens de estoque.
     */
    public function index()
    {
        $itens = EstoqueItem::with(['produto'])->paginate(20);

        return inertia('Estoque/Itens/Index', [
            'itens' => $itens,
        ]);
    }

    /**
     * Mostra o formulário de criação
     */
    public function create()
    {
        return inertia('Estoque/Itens/Create');
    }

    /**
     * Salva um novo item de estoque
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|numeric|min:0',
            'descricao'  => 'nullable|string|max:255',
        ]);

        EstoqueItem::create($validated);

        return redirect()->route('estoque-itens.index')
            ->with('success', 'Item criado com sucesso!');
    }

    /**
     * Mostra formulário de edição
     */
    public function edit(EstoqueItem $estoqueItem)
    {
        return inertia('Estoque/Itens/Edit', [
            'item' => $estoqueItem
        ]);
    }

    /**
     * Atualiza um item do estoque.
     */
    public function update(Request $request, EstoqueItem $estoqueItem)
    {
        $validated = $request->validate([
            'quantidade' => 'required|numeric|min:0',
            'descricao'  => 'nullable|string|max:255',
        ]);

        $estoqueItem->update($validated);

        return redirect()->route('estoque-itens.index')
            ->with('success', 'Item atualizado!');
    }

    /**
     * Remove um item de estoque.
     */
    public function destroy(EstoqueItem $estoqueItem)
    {
        $estoqueItem->delete();

        return redirect()->route('estoque-itens.index')
            ->with('success', 'Item removido!');
    }
}
