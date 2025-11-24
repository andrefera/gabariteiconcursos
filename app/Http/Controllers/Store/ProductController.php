<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Modules\Store\Products\DTO\ProductDetailDTO;
use App\Modules\Store\Products\Services\Actions\GetRelatedProducts;
use App\Modules\Store\Products\Services\Actions\ListStoreProducts;
use App\Modules\Store\Teams\Services\Actions\GetTeamByUrl;
use App\Modules\Store\Teams\Services\Actions\GetTeams;
use App\Support\Util\SeoUrlHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request, ?string $filters = null): View|RedirectResponse
    {
        // Se houver query strings, redirecionar para URL amigável (301 redirect para SEO)
        if ($request->hasAny(['team', 'gender', 'season', 'category', 'price_min', 'price_max', 'size', 'product_type', 'national_international', 'sort', 'page'])) {
            $queryParams = $request->query();
            $friendlyUrl = SeoUrlHelper::queryStringToUrl('/camisas', $queryParams);
            return redirect($friendlyUrl, 301);
        }

        // Processar filtros da URL amigável
        $filtersArray = [];
        if ($filters) {
            $filtersArray = SeoUrlHelper::urlToFilters('/camisas/' . $filters);
        }

        $search = $request->get('search');
        $team = $filtersArray['team'] ?? null;
        $gender = $filtersArray['gender'] ?? null;
        $season = $filtersArray['season'] ?? null;
        $category = $filtersArray['category'] ?? null;
        $priceMin = $filtersArray['price_min'] ?? null;
        $priceMax = $filtersArray['price_max'] ?? null;
        $size = $filtersArray['size'] ?? null;
        $productType = $filtersArray['product_type'] ?? null;
        $nationalInternational = $filtersArray['national_international'] ?? null;
        $sort = $filtersArray['sort'] ?? 'most_sold';
        $page = (int) ($filtersArray['page'] ?? 1);
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

        // Se houver um time nos filtros, buscar informações do time
        $teamData = null;
        if ($team) {
            $getTeamAction = new GetTeamByUrl($team);
            $teamData = $getTeamAction->execute();
        }

        return view('list.index', [
            'products' => $result['products'],
            'total' => $result['total'],
            'currentPage' => $result['current_page'],
            'lastPage' => $result['last_page'],
            'perPage' => $result['per_page'],
            'team' => $teamData,
            'teams' => $teams,
            'availableFilters' => $result['available_filters'] ?? [],
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

        return view('details.index', [
            'product' => ProductDetailDTO::fromProduct($product),
            'related_products' => (new GetRelatedProducts($product->id))->execute()
        ]);
    }


}
