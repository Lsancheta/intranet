<?php
namespace App\Services;

use App\Models\EstoqueItem;
use App\Models\DepositoItem;
use App\Models\Local;
use App\Models\TipoTransferencia;
use DomainException;

class EstoqueService{

    // vai decidir de acordo com o tipo de transferencia

    public function processar(
        TipoTransferencia $tipo,
        ?Local $origem,
        ?Local $destino,
        array $itens
    ): void{
        // aqui será os switchs
        switch ($tipo->id){
            case 1:
                // Entrada no estoque - sempre irá adicionar produtos no destino
                if(!$destino){
                        throw new DomainException('Destino obrigatório');
                }
                //isso irá validar se o destino existe antes de entrar no loop de ação.
                $this->validarDestino($destino);

                foreach ($itens as $item){
                    $produtoId = $item['produto_id'];
                    $quantidade = $item['quantidade'];

                    if($destino->tipo ==='deposito'){
                        $this->incrementarDeposito(
                            $produtoId,
                            $destino->id,
                            $quantidade
                        );
                    } else{
                        $this->incrementarEstoque(
                            $produtoId,
                            $destino->id,
                            $quantidade
                        );
                    }
                    }
            break;
    
            case 2:
                //Saída - sempre ira subtrair um valor de produto
                if(!$origem){
                        throw new DomainException('Origem Obrigatório');

                }

                $this->validarOrigem($origem);

                foreach($itens as $item){
                    $produtoId = $item['produto_id'];
                    $quantidade = $item['quantidade'];

                    if($origem->tipo ==='deposito'){
                        $this->validarDeposito(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                        $this->decrementarDeposito(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                    }else{
                        $this->validarEstoque(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                        $this->decrementarEstoque(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                    }
                }
            break;

            case 3:
                // transferencia - aqui acontece o incremento e o decremento de itens de ambos estoques.
                if(!$origem){
                        throw new DomainException('Origem Obrigatório');
                }
                if(!$destino){
                        throw new DomainException('Destino Obrigatório');
                }

                $this->validarDestino($destino);
                $this->validarOrigem($origem);
                
                foreach($itens as $item){
                    $produtoId = $item['produto_id'];
                    $quantidade = $item['quantidade'];
                    
                    //origem
                    if($origem->tipo ==='deposito'){
                        $this->validarDeposito(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                        $this->decrementarDeposito(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                    
                    }else {
                        $this->validarEstoque(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                        $this->decrementarEstoque(
                            $produtoId,
                            $origem->id,
                            $quantidade
                        );
                    
                    }
                    //destino
                    if($destino->tipo === 'deposito'){
                       
                        $this->incrementarDeposito(
                            $produtoId,
                            $destino->id,
                            $quantidade
                        );
                    }else{
                      
                        $this->incrementarEstoque(
                            $produtoId,
                            $destino->id,
                            $quantidade
                        );
                    }
                }
            break;
        }
    }

    // métodos de validações ou regras de negócio

    protected function validarOrigem(Local $origem):void{
        if(!in_array($origem->tipo,['deposito','estoque'])){
            throw new DomainException('Origem inválido');
        }
    }

    protected function validarDestino(Local $destino):void{
        if(!in_array($destino->tipo,['deposito','estoque'])){
            throw new DomainException('Destino Inválido');
        }
    }

    protected function validarDeposito($produtoId, $localId, $quantidade): void{
        $item = $this->obterDepositoItem($produtoId, $localId);
        if ($item->quantidade < $quantidade){
            throw new DomainException('Quantidade Insuficiente no depósito.');
        }
        
    }

    protected function validarEstoque($produtoId, $localId, $quantidade): void{
        $item = $this->obterEstoqueItem($produtoId, $localId);
        if($item->quantidade < $quantidade){
            throw new DomainException('Quantidade Insuficiente no estoque.');
        }

    }

    protected function obterDepositoItem($produtoId, $localId): DepositoItem{
        return DepositoItem::firstOrCreate([
            'produto_id' => $produtoId,
            'local_id' => $localId,
        ]);

    }

    protected function obterEstoqueItem($produtoId, $localId): EstoqueItem{
       return EstoqueItem::firstOrCreate([
            'produto_id' => $produtoId,
            'local_id' => $localId,
       ]);
    }

    // MÉTODO DE TRANSFERENCIAS

    protected function incrementarDeposito($produtoId, $localId, $quantidade): void{
        $item = $this->obterDepositoItem($produtoId, $localId);
        $item->increment('quantidade', $quantidade);
    }

    protected function decrementarDeposito($produtoId, $localId, $quantidade): void{
        $item = $this->obterDepositoItem($produtoId, $localId);
        $item->decrement('quantidade', $quantidade);
    }

    protected function incrementarEstoque($produtoId, $localId, $quantidade): void{
        $item = $this->obterEstoqueItem($produtoId, $localId);
        $item->increment('quantidade', $quantidade);
    }

    protected function decrementarEstoque($produtoId, $localId, $quantidade): void{
        $item = $this->obterEstoqueItem($produtoId, $localId);
        $item->decrement('quantidade', $quantidade);

    }

    protected function ajustarLocal($produtoId, $localId, $quantidade): void{


    }

}
