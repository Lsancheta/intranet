<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\EstoqueItem;
use App\Models\DepositoItem;
use App\Models\Transferencia;
use App\Models\TransferenciaItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\EstoqueServices;

class EstoqueController extends Controller
{
    /**
     * Página inicial do módulo de estoque.
     */
    public function index()
    {
        return Inertia::render('Estoque/Index', [
            'total_produtos' => Produto::count(),
            'total_deposito' => DepositoItem::sum('quantidade'),
            'total_estoque' => EstoqueItem::sum('quantidade'),

            'produtos_baixo_estoque' => EstoqueItem::with('produto', 'local')
                ->whereColumn('quantidade', '<', 'estoque_minimo')
                ->orderBy('quantidade', 'asc')
                ->take(10)
                ->get(),

            'top_consumidos' => TransferenciaItem::selectRaw('produto_id, SUM(quantidade) as total')
                ->where('tipo_id', 2) // saída/consumo
                ->groupBy('produto_id')
                ->orderByDesc('total')
                ->take(5)
                ->with('produto')
                ->get(),

            'previsao_reposicao' => $this->calcularReposicao(),

            'pendentes' => TransferenciaItem::where('status', 'pendente')
                ->with(['itens.produto', 'destino', 'usuario'])
                ->get(),
        ]);
    }

    /**
     * Calcula previsões de reposição com base no consumo recente.
     *
     * Aqui é apenas um exemplo simples.
     * Se quiser mais precisão depois (média móvel, peso por semana, sazonalidade),
     * é só pedir que evoluímos.
     */
    private function calcularReposicao()
    {
        // Exemplo básico:
        // Pega consumo dos últimos 30 dias.
        $consumos = TransferenciaItem::selectRaw('produto_id, SUM(quantidade) as total')
            ->where('tipo_id', 2)
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('produto_id')
            ->get();

        $resultado = [];

        foreach ($consumos as $c) {
            $item = EstoqueItem::where('produto_id', $c->produto_id)->first();
            if (!$item) continue;

            $media_diaria = $c->total / 30; // consumo médio por dia

            if ($media_diaria <= 0) continue;

            $dias_restantes = $item->quantidade / $media_diaria;

            $resultado[] = [
                'produto' => $item->produto,
                'quantidade_atual' => $item->quantidade,
                'media_diaria' => round($media_diaria, 2),
                'dias_para_acabar' => round($dias_restantes, 1),
            ];
        }

        return $resultado;
    }
}
