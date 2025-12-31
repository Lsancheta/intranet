<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    /**
     * Lista todos os produtos.
     */
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();

        return Inertia::render('Produtos/Index', [
            'produtos' => $produtos
        ]);
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create()
    {
        return Inertia::render('Produtos/Create');
    }

    /**
     * Salva um novo produto.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'peso_unitario' => 'nullable|numeric|min:0',
        ]);

        Produto::create($request->only('nome', 'unidade', 'peso_unitario'));

        return redirect()->route('produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(Produto $produto)
    {
        return Inertia::render('Produtos/Edit', [
            'produto' => $produto
        ]);
    }

    /**
     * Atualiza um produto existente.
     */
    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'peso_unitario' => 'nullable|numeric|min:0',
        ]);

        $produto->update($request->only('nome', 'unidade', 'peso_unitario'));

        return redirect()->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove um produto.
     */
    public function destroy(Produto $produto)
    {
        // Validação: impedir exclusão se já houve movimentações
        if ($produto->transferencias()->exists()) {
            return back()->with('error', 'Não é possível excluir um produto com movimentações registradas.');
        }

        $produto->delete();

        return redirect()->route('produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
