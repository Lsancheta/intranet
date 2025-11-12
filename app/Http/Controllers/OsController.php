<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;



class OsController extends Controller
{
    
    public function index(){
        return Inertia::render('Ordens/Index');
    }

    public function create(){
        return Inertia::render('Ordens/Create');
    }
    public function store(Request $request){
        // logica para salvar a OS no BD
    }

    public function show($id){
        return Inertia::render('Ordens/Show',[
    ]);
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