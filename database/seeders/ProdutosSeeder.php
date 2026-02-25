<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Produto;

class ProdutosSeeder extends Seeder
{
    public function run(): void
    {
        $produtos = [
            ['nome' => 'SAL', 'unidade' => 'Kg', 'preco_custo' => 1.40],
            ['nome' => 'ÓLEO', 'unidade' => 'Litros', 'preco_custo' => 7.69],
            ['nome' => 'ÓLEO DE ALGODÃO', 'unidade' => 'Litros', 'preco_custo' => 11.86],
            ['nome' => 'ALHO', 'unidade' => 'Kg', 'preco_custo' => 15.00],
            ['nome' => 'CEBOLA', 'unidade' => 'Kg', 'preco_custo' => 4.50],
            ['nome' => 'MACARRÃO ESPAGUETE', 'unidade' => 'Pacote', 'preco_custo' => 1.89],
            ['nome' => 'MACARRÃO PARAFUSO', 'unidade' => 'Pacote', 'preco_custo' => 1.95],
            ['nome' => 'EXTRATO DE TOMATE', 'unidade' => 'Kg', 'preco_custo' => 20.79],
            ['nome' => 'VINAGRE', 'unidade' => 'Litros', 'preco_custo' => 1.49],
            ['nome' => 'AMIDO DE MILHO', 'unidade' => 'Kg', 'preco_custo' => 6.59],
            ['nome' => 'FARINHA DE MANDIOCA', 'unidade' => 'Kg', 'preco_custo' => 6.09],
            ['nome' => 'FARINHA BIJOU', 'unidade' => 'Kg', 'preco_custo' => 5.90],
            ['nome' => 'FARINHA DE TRIGO', 'unidade' => 'Kg', 'preco_custo' => 2.90],
            ['nome' => 'SUCO', 'unidade' => 'Pacote', 'preco_custo' => 7.59],
            ['nome' => 'FUBÁ', 'unidade' => 'Kg', 'preco_custo' => 3.38],
            ['nome' => 'BATATA PALHA', 'unidade' => 'Pacote', 'preco_custo' => 8.50],
            ['nome' => 'OVOS', 'unidade' => 'Unidade', 'preco_custo' => 1.29],
            ['nome' => 'CARNE MOÍDA', 'unidade' => 'Kg', 'preco_custo' => 15.80],
            ['nome' => 'LINGUIÇA TOSCANA', 'unidade' => 'Kg', 'preco_custo' => 14.10],
            ['nome' => 'SALSICHA', 'unidade' => 'Kg', 'preco_custo' => 7.49],
            ['nome' => 'FRANGO ASSADO', 'unidade' => 'Kg', 'preco_custo' => 10.60],
            ['nome' => 'QUIABO', 'unidade' => 'Kg', 'preco_custo' => 13.00],
            ['nome' => 'CENOURA', 'unidade' => 'Kg', 'preco_custo' => 3.25],
            ['nome' => 'ALFACE', 'unidade' => 'Unidade', 'preco_custo' => 5.00],
            ['nome' => 'COUVE', 'unidade' => 'Unidade', 'preco_custo' => 5.00],
            ['nome' => 'TOMATE', 'unidade' => 'Kg', 'preco_custo' => 6.00],
            ['nome' => 'BANANA', 'unidade' => 'Kg', 'preco_custo' => 5.50],
            ['nome' => 'BATATA', 'unidade' => 'Kg', 'preco_custo' => 4.60],
            ['nome' => 'MANDIOCA', 'unidade' => 'Kg', 'preco_custo' => 5.50],
            ['nome' => 'MAIONESE', 'unidade' => 'Kg', 'preco_custo' => 8.35],
            ['nome' => 'MOSTARDA', 'unidade' => 'Kg', 'preco_custo' => 12.79],
            ['nome' => 'LEITE', 'unidade' => 'Litros', 'preco_custo' => 3.89],
            ['nome' => 'LEITE EM PÓ', 'unidade' => 'Kg', 'preco_custo' => 12.77],
        ];

        foreach ($produtos as $produto) {
            Produto::firstOrCreate(
                ['nome' => $produto['nome']],
                [
                    'unidade' => $produto['unidade'],
                    'preco_custo' => $produto['preco_custo'],
                    'estoque_minimo' => 100,
                    'ativo' => 1,
                ]
            );
        }
    }
}
