<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Store\Products\DTO\ProductDetailDTO;
use App\Modules\Store\Products\Services\Actions\ListStoreProducts;
use App\Modules\Store\Teams\Services\Actions\GetTeamByUrl;
use App\Modules\Store\Teams\Services\Actions\GetTeams;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request): View
    {
        $search = $request->get('search');
        $team = $request->get('team');
        $gender = $request->get('gender');
        $season = $request->get('season');
        $category = $request->get('category');
        $priceMin = $request->get('price_min');
        $priceMax = $request->get('price_max');
        $size = $request->get('size');
        $productType = $request->get('product_type');
        $nationalInternational = $request->get('national_international');
        $sort = $request->get('sort', 'most_sold');
        $page = (int) $request->get('page', 1);
        $perPage = 12;

        $action = new ListStoreProducts(
            search: $search,
            team: $team,
            gender: $gender,
            season: $season,
            category: $category,
            priceMin: $priceMin,
            priceMax: $priceMax,
            size: $size,
            productType: $productType,
            nationalInternational: $nationalInternational,
            sort: $sort,
            page: $page,
            perPage: $perPage
        );

        $result = $action->execute();

        // Buscar times para o filtro
        $getTeamsAction = new GetTeams();
        $teams = $getTeamsAction->execute();

        return view('list.index', [
            'products' => $result['products'],
            'total' => $result['total'],
            'currentPage' => $result['current_page'],
            'lastPage' => $result['last_page'],
            'perPage' => $result['per_page'],
            'teams' => $teams,
            'filters' => [
                'search' => $search,
                'team' => $team,
                'gender' => $gender,
                'season' => $season,
                'category' => $category,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
                'size' => $size,
                'product_type' => $productType,
                'national_international' => $nationalInternational,
                'sort' => $sort
            ]
        ]);
    }

    public function detail(Request $request): View
    {
        $url = $request->getPathInfo();
        $product = Product::query()
            ->where('url', $url)
            ->where('is_active', true)
            ->first();

        if (!$url || !$product) {
            abort(404);
        }

        return view('details.index', ['product' => ProductDetailDTO::fromProduct($product)]);
    }

    public function teamProducts(Request $request, string $teamUrl): View
    {
        // Buscar informações do time
        $getTeamAction = new GetTeamByUrl($teamUrl);
        $team = $getTeamAction->execute();

        if (!$team) {
            abort(404);
        }

        $search = $request->get('search');
        $gender = $request->get('gender');
        $season = $request->get('season');
        $category = $request->get('category');
        $priceMin = $request->get('price_min');
        $priceMax = $request->get('price_max');
        $size = $request->get('size');
        $productType = $request->get('product_type');
        $nationalInternational = $request->get('national_international');
        $sort = $request->get('sort', 'most_sold');
        $page = (int) $request->get('page', 1);
        $perPage = 12;

        $action = new ListStoreProducts(
            search: $search,
            team: $teamUrl,
            gender: $gender,
            season: $season,
            category: $category,
            priceMin: $priceMin,
            priceMax: $priceMax,
            size: $size,
            productType: $productType,
            nationalInternational: $nationalInternational,
            sort: $sort,
            page: $page,
            perPage: $perPage
        );

        $result = $action->execute();

        // Buscar times para o filtro
        $getTeamsAction = new GetTeams();
        $teams = $getTeamsAction->execute();

        return view('list.index', [
            'products' => $result['products'],
            'total' => $result['total'],
            'currentPage' => $result['current_page'],
            'lastPage' => $result['last_page'],
            'perPage' => $result['per_page'],
            'team' => $team,
            'teams' => $teams,
            'filters' => [
                'search' => $search,
                'team' => $teamUrl,
                'gender' => $gender,
                'season' => $season,
                'category' => $category,
                'price_min' => $priceMin,
                'price_max' => $priceMax,
                'size' => $size,
                'product_type' => $productType,
                'national_international' => $nationalInternational,
                'sort' => $sort
            ]
        ]);
    }

}
