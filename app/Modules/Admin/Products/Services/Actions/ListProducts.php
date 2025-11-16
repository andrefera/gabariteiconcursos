<?php

namespace App\Modules\Admin\Products\Services\Actions;

use App\Modules\Admin\Products\DTO\ListProductsDTO;
use App\Support\Util\ElasticSearchUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

readonly class ListProducts
{
    public function __construct(
        private ?int    $id,
        private ?string $name,
        private ?string $sku,
        private ?string $type,
        private ?bool   $is_active,
        private ?string $team_name,
        private ?string $team_url,
        private ?string $category,
        private ?string $gender,
        private int     $page = 1,
        private int     $limit = 50
    )
    {
    }

    public function execute(): ListProductsDTO
    {

        $query = [
            "bool" => [
                "must" => $this->getFilter()
            ]
        ];

        $start = ($this->page - 1) * $this->limit;
        $response = ElasticSearchUtil::search(config('services.elastic_search.products_index'), $query, [], $start, $this->limit, ['id' => 'DESC']);
        $total = $response['hits']['total']['value'];

        $products = collect($response['hits']['hits'])->map(function ($item) {
            return $item['_source'];
        })->toArray();

        return new ListProductsDTO(
            $products,
            $total,
            $this->page,
            ceil($total / $this->limit),
            $this->limit
        );

    }

    public function getFilter(): Collection
    {
        $must = collect();

        if ($this->id) {
            $must->push([
                'term' => [
                    'id' => $this->id
                ]
            ]);
        }

        if ($this->name) {
            $must->push([
                'query_string' => [
                    'query' => '*' . $this->name . '*',
                    'fields' => ['name'],
                ]
            ]);
        }

        $params = [
            'sku' => $this->sku,
            'type' => $this->type,
            'is_active' => is_bool($this->is_active) ? ($this->is_active ? "Sim" : "Não") : null,
            'team_name' => $this->team_name,
            'team_url' => $this->team_url,
            'categories' => $this->category,
            'gender' => $this->gender,
        ];

        foreach ($params as $key => $param) {
            if ($param) {
                $must->push([
                    'term' => [
                        $key . '.keyword' => $param
                    ]
                ]);
            }
        }

        return $must;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('id'),
            $request->get('name'),
            $request->get('sku'),
            $request->get('type'),
            !$request->get('is_active') ? null : $request->get('is_active') == 'true',
            $request->get('team_name'),
            $request->get('team_url'),
            $request->get('category'),
            $request->get('gender'),
            $request->get('page'),
            $request->get('limit')
        );
    }
}
