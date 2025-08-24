<?php

namespace App\Modules\Store\Products\Services\Actions;

use App\Modules\Admin\Products\Mappers\ProductGenderMapper;
use App\Support\Util\ElasticSearchUtil;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class ListStoreProducts
{
    public function __construct(
        private ?string $search = null,
        private ?string $team = null,
        private ?string $gender = null,
        private ?string $season = null,
        private ?string $category = null,
        private ?string $priceMin = null,
        private ?string $priceMax = null,
        private ?string $size = null,
        private ?string $productType = null,
        private ?string $nationalInternational = null,
        private string $sort = 'most_sold',
        private int $page = 1,
        private int $perPage = 12
    ) {}

    public function execute(): array
    {
        $query = [
            "bool" => [
                "must" => $this->buildQuery()
            ]
        ];

        $start = ($this->page - 1) * $this->perPage;

        $products = ElasticSearchUtil::search(
            env('ELASTIC_SEARCH_INDEX_PRODUCTS', 'products_index'),
            $query,
            [],
            $start,
            $this->perPage,
            $this->getSortOrder()
        );

        if (!$products || !isset($products['hits']['hits'])) {
            return [
                'products' => [],
                'total' => 0,
                'current_page' => $this->page,
                'per_page' => $this->perPage,
                'last_page' => 1
            ];
        }

        $total = $products['hits']['total']['value'] ?? 0;
        $lastPage = ceil($total / $this->perPage);

        $productData = collect($products['hits']['hits'])->map(function ($hit) {
            $source = $hit['_source'];
            return $this->mapToHomeProductDTO($source);
        })->toArray();

        Log::info($productData);
        Log::info($query);

        return [
            'products' => $productData,
            'total' => $total,
            'current_page' => $this->page,
            'per_page' => $this->perPage,
            'last_page' => $lastPage
        ];
    }

    private function buildQuery(): Collection
    {
        $must = collect();

        $must->push([
            'term' => [
                'is_active.keyword' => 'Sim'
            ]
        ]);

        if ($this->search) {
            $must->push([
                'query_string' => [
                    'query' => '*' . $this->search . '*',
                    'fields' => ['name'],
                ]
            ]);
        }

        // Filtro por time
        if ($this->team) {
            $must->push([
                'term' => [
                    'team_url.keyword' => $this->team
                ]
            ]);
        }

        // Filtro por gênero (múltiplos valores)
        if ($this->gender) {
            $genders = explode(',', $this->gender);
            if (count($genders) > 1) {
                $must->push([
                    'terms' => [
                        'gender.keyword' => array_map(fn($gender) => (new ProductGenderMapper())($gender), $genders)
                    ]
                ]);
            } else {
                $must->push([
                    'term' => [
                        'gender.keyword' => (new ProductGenderMapper())($this->gender)
                    ]
                ]);
            }
        }

        // Filtro por temporada
        if ($this->season) {
            $must->push([
                'term' => [
                    'season.keyword' => $this->season
                ]
            ]);
        }

        // Filtro por categoria (múltiplos valores)
        if ($this->category) {
            $categories = explode(',', $this->category);
            if (count($categories) > 1) {
                $must->push([
                    'terms' => [
                        'categories.keyword' => $categories
                    ]
                ]);
            } else {
                $must->push([
                    'term' => [
                        'categories.keyword' => $this->category
                    ]
                ]);
            }
        }

        // Filtro por preço
        if ($this->priceMin || $this->priceMax) {
            $range = [];
            if ($this->priceMin) {
                $range['gte'] = (float) $this->priceMin;
            }
            if ($this->priceMax) {
                $range['lte'] = (float) $this->priceMax;
            }
            
            $must->push([
                'range' => [
                    'price' => $range
                ]
            ]);
        }

        // Filtro por tamanho (múltiplos valores)
        if ($this->size) {
            $sizes = explode(',', $this->size);
            if (count($sizes) > 1) {
                $must->push([
                    'terms' => [
                        'sizes.keyword' => $sizes
                    ]
                ]);
            } else {
                $must->push([
                    'term' => [
                        'sizes.keyword' => $this->size
                    ]
                ]);
            }
        }

        // Filtro por tipo de produto
        if ($this->productType) {
            $must->push([
                'term' => [
                    'type.keyword' => $this->productType
                ]
            ]);
        }

        // Filtro por nacional/internacional (múltiplos valores)
        if ($this->nationalInternational) {
            $nationalInternationals = explode(',', $this->nationalInternational);
            if (count($nationalInternationals) > 1) {
                $must->push([
                    'terms' => [
                        'is_national.keyword' => $nationalInternationals
                    ]
                ]);
            } else {
                $must->push([
                    'term' => [
                        'is_national.keyword' => $this->nationalInternational
                    ]
                ]);
            }
        }

        return $must;
    }

    private function getSortOrder(): array
    {
        return match($this->sort) {
            'newest' => ['id' => 'DESC'],
            'promotions' => ['discount_percentage' => 'DESC'],
            'price_asc' => ['price' => 'ASC'],
            'price_desc' => ['price' => 'DESC'],
            default => ['total_orders' => 'DESC'] // most_sold
        };
    }

    private function mapToHomeProductDTO(array $source): array
    {
        $price = (float) ($source['price'] ?? 0);
        $specialPrice = isset($source['special_price']) ? (float) $source['special_price'] : null;
        $installmentPrice = ($specialPrice ?? $price) / 12;
        $stock = (int) ($source['stock'] ?? 0);

        return [
            'id' => (int) ($source['id'] ?? 0),
            'name' => $source['name'] ?? '',
            'url' => $source['url'] ?? '',
            'price' => "R$ " . number_format($price, 2, ',', '.'),
            'special_price' => $specialPrice ? ("R$ " . number_format($specialPrice, 2, ',', '.')) : null,
            'discount_percentage' => isset($source['discount_percentage']) && $source['discount_percentage'] > 0 ? ($source['discount_percentage'] . '% OFF') : null,
            'installment_price' => "em até 12x de R$ " . number_format($installmentPrice, 2, ',', '.'),
            'image' => $source['images'][0] ?? null,
            'team_name' => $source['team_name'] ?? null,
            'gender' => $source['gender'] ?? '',
            'season' => $source['season'] ?? '',
            'stock' => $stock,
        ];
    }
}
