<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetorMiddleware
{
    public function handle($request, Closure $next, ...$setores)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        // Administrativo (setor 1) tem acesso total
        if ($user->inSetor(1)) {
            return $next($request);
        }

        // Apenas permitido se o usuário estiver nos setores exigidos
        if (!$user->inSetor($setores)) {
            abort(403, 'Você não tem permissão para acessar esta área.');
        }

        return $next($request);
    }
}
