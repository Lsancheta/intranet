<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Quantitativo;

class QuantitativoController extends Controller
{
    public function index(Request $request){

        $alojamentos = \App\Models\Alojamento::with('blocos')->get();

        // Load quantitativo records with related alojamento and bloco
        $quantitativos = Quantitativo::with(['alojamento', 'bloco'])->orderByDesc('id')->get();

        return Inertia::render('Quantitativo/Index', [
            'alojamentos' => $alojamentos,
            'quantitativo' => $quantitativos,
        ]);
    }

     public function create(Request $request){
        return Inertia::render('quantitativo/Create');
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            'fazenda' => 'required',
            'nome' => 'required',
            'quantidade' => 'required|integer',
            'alojamento_id' => 'required|exists:alojamentos,id',
            'bloco_id' => 'required|exists:blocos,id',
        ]);

        $quant = Quantitativo::findOrFail($id);
        $quant->update($data);

        return redirect()->route('quantitativo.index')->with('success', 'Quantitativo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $quant = Quantitativo::findOrFail($id);
        $quant->delete();

        return redirect()->route('quantitativo.index')->with('success', 'Quantitativo removido com sucesso!');
    }

    public function store(Request $request){
        $request->validate([
            'fazenda' => 'required',
            'nome' => 'required',
            'quantidade' => 'required|integer',
            'alojamento_id' => 'required|exists:alojamentos,id',
            'bloco_id' => 'required|exists:blocos,id',
        ]);

        Quantitativo::create($request->all());

        return redirect()->route('quantitativo.index')->with('success', 'Quantitativo criado com sucesso!');
    }
}
