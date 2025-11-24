<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Controllers\UserController;

class AdminController extends Controller
{
    // Página inicial da administração
    public function index()
    {
        return Inertia::render('Admin/Index');
    }

    // Lista de usuários
    public function usuarios()
    {
        return Inertia::render('Admin/Usuarios', [
            'usuarios' => User::orderBy('name')->get(),
        ]);
    }

    // Formulário de novo usuário
    public function createUsuario()
    {
        return Inertia::render('Admin/Usuarios/Novo');
    }

    // Salvar usuário
    public function storeUsuario(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.usuarios')->with('success', 'Usuário criado com sucesso!');
    }
}
