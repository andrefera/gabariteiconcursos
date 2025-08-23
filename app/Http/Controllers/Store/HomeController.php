<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Modules\Store\Products\Services\Actions\GetHomeProducts;
use App\Modules\Store\Products\Services\Actions\GetEuropeanTeamsProducts;
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
        
        return view('home', compact('products', 'europeanProducts'));
    }
}
