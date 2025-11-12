<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OsController extends Controller
{

    public function index(){
        return view('ordem-servico.index');
    }

    public function create(){
        return view('ordem-servico.create');
    }
    public function store(Request $request){
        // logica para salvar a OS no BD
    }

    public function show($id){
        return view('ordem-servico.show');
    }

    public function edit($id){
        return view('ordem-servico.edit');
    }

    public function update(Request $request, $id){
        // logica para update
    }

    public function destroy($id){
        //lógica para delete
    }
}