<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Usuarios/Index', [
            'usuarios' => User::with('setores')->get()
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Usuarios/Criar', [
            'setores' => Setor::all()
        ]);
    }
    // criar
    public function store(Request $request)
    {
       // dd($request->all());
        $data = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'password' => 'required|min:4',
            'setores' => 'array|required',
            'setores.*'=>'exists:setores,id',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password']),

        ]);

        $user->setores()->sync($data['setores']);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }
    //update
    //update
    public function edit($id){
        $user = User::with('setores')->findOrFail($id);

        return Inertia::render('Admin/Usuarios/Editar', [
            'user' => $user,
            'setores' => Setor::all()
        ]);
    }

    public function update(Request $request, $id){
        $data = $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'password' => 'nullable|min:4',
            'setores' => 'array|required',
            'setores.*' => 'exists:setores,id'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
                ? Hash::make($data['password'])
                : $user->password
        ]);

        $user->setores()->sync($data['setores']);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    

    //delete
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('Success, Usuário removido.');
    }
}
