<?php

namespace App\Modules\Store\Products\Services\Actions;

use App\Modules\Store\Products\DTO\IncidenceDTO;
use App\Support\Util\ElasticSearchUtil;
use Illuminate\Support\Collection;

readonly class IncidenceFilterProducts
{
    public function __construct(
        private string $field,
        private ?string $country,
    )
    {
    }

    public function execute(): array
    {
        $query = [
            'bool' => [
                'filter' => $this->getFilter()
            ]
        ];

        $products = ElasticSearchUtil::search(config('services.elastic_search.products_index'),
            $query,
            [
                "unique_ids" => [
                    "terms" => [
                        "field" => $this->field . ".keyword",
                        "size" => 10000
                    ]
                ]
            ],
            0,
            1,
        );

        if (!$products) {
            return [];
        }

        return collect($products['aggregations']['unique_ids']['buckets'])->map(fn($item) => new IncidenceDTO($item["key"], $item['doc_count']))->toArray();
    }

    private function getFilter(): Collection
    {
        $filter = collect([]);
        return $filter;
    }
}
