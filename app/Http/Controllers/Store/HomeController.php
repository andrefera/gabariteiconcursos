<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Store\Products\Services\Actions\GetHomeProducts;
use App\Modules\Store\Products\Services\Actions\GetEuropeanTeamsProducts;
use App\Modules\Store\Teams\Services\Actions\GetTeams;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): View
    {
        $getHomeProductsAction = new GetHomeProducts();
        $products = $getHomeProductsAction->execute();
        
        $getEuropeanTeamsProductsAction = new GetEuropeanTeamsProducts();
        $europeanProducts = $getEuropeanTeamsProductsAction->execute();
        
        // Buscar times brasileiros
        $getTeamsAction = new GetTeams();
        $allTeams = $getTeamsAction->execute();
        $brazilianTeams = array_filter($allTeams, function($team) {
            return $team['country'] === 'BR' && $team['league'] !== 'Seleção';
        });
        
        return view('home', compact('products', 'europeanProducts', 'brazilianTeams'));
    }
}
