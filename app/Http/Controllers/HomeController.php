<?php
namespace App\Http\Controllers;
use App\Models\OrdemServico;
use Inertia\Inertia;

class HomeController extends Controller{

    //public function index(){
    //    return view('home');
    // }
    public function index()
    {
        $total = OrdemServico::count();
        $osResolvidas = OrdemServico::where('status_id', 4)->count();
        $osPendentes = OrdemServico::where('status_id', 3)->count();
        $osAbertas = OrdemServico::where('status_id', 1)->count();
        $osEmAndamento = OrdemServico::where('status_id', 2)->count();

        return Inertia::render('Welcome', [
            'totalOs' => $total,
            'osResolvidas' => $osResolvidas,
            'osPendentes' => $osPendentes,
            'osAbertas' => $osAbertas,
            'osEmAndamento' => $osEmAndamento,
        ]);
    }
}

