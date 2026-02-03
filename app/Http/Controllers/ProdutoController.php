<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->get();

        return Inertia::render('Produtos/Index', [
            'produtos' => $produtos
        ]);
    }

    public function create()
    {
        return Inertia::render('Produtos/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'preco_custo' => 'required|numeric|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'ativo' => 'boolean'
        ]);

        Produto::create([
            'nome' => $request->nome,
            'unidade' => $request->unidade,
            'preco_custo' => $request->preco_custo,
            'estoque_minimo' => $request->estoque_minimo,
            'ativo' => $request->ativo ?? true,
        ]);

        return redirect()->route('estoque.produtos.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit($id)
    {
        $produto = Produto::findOrFail($id);

        return Inertia::render('Produtos/Edit', [
            'produto' => $produto
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'preco_custo' => 'required|numeric|min:0',
            'estoque_minimo' => 'required|integer|min:0',
            'ativo' => 'boolean'
        ]);

        $produto = Produto::findOrFail($id);

        $produto->update([
            'nome' => $request->nome,
            'unidade' => $request->unidade,
            'preco_custo' => $request->preco_custo,
            'estoque_minimo' => $request->estoque_minimo,
            'ativo' => $request->ativo,
        ]);

        return redirect()->route('estoque.produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        if ($produto->itensTransferencias()->exists()) {
            return back()->with('error', 'Não é possível excluir um produto com movimentações registradas.');
        }

        $produto->delete();

        return redirect()->route('estoque.produtos.index')
            ->with('success', 'Produto excluído com sucesso!');
    }
}
