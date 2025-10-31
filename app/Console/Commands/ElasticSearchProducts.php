<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Modules\Admin\Products\Services\Actions\InsertProductElasticSearch;
use App\Support\Util\ElasticSearchUtil;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ElasticSearchProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic-search:products {create=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws AuthenticationException
     * @throws Exception
     */
    public function handle(): void
    {
        $create = $this->argument('create') == 'true';
        if ($create) {
            $this->createIndex();
        }

        $this->insertProducts();
    }


    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndex(): void
    {
        $index = env('ELASTIC_SEARCH_INDEX_PRODUCTS', 'products_index');

        try {
            ElasticSearchUtil::deleteIndex($index);
        } catch (Throwable $e) {
        }

        $setMapText = [
            "type" => "text",
            "analyzer" => "folding",
            "search_analyzer" => "folding",
            "fields" => [
                "keyword" => [
                    "type" => "keyword",
                    "ignore_above" => 256
                ]
            ]
        ];

        $setMapInteger = [
            "type" => "integer"
        ];

        ElasticSearchUtil::createIndex($index, [
            'index' => [
                'max_result_window' => 999999
            ],
            'analysis' => [
                'analyzer' => [
                    'folding' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'asciifolding']
                    ]
                ]
            ]
        ], [
            'properties' => [
                'id' => $setMapInteger,        // campo numérico
                'name' => $setMapText,         // campo de texto
                'total_orders' => $setMapInteger // campo numérico
            ]
        ]);
    }

    /**
     * @throws Exception
     */
    public function insertProducts(): void
    {
        $page = 1;

        do {
            $products = Product::withTrashed()
                ->orderByDesc('id')
                ->paginate(500, ['*'], 'page', $page);

            /**
             * @var Product $product
             */
            foreach ($products->items() as $product) {
                InsertProductElasticSearch::fromProduct($product)->execute();
            }

            if (count($products->items()) > 0) {
                Log::info("Inserindo produtos | página $page/" . $products->lastPage());
            }

            $page++;

        } while (count($products->items()) > 0);
    }
}
