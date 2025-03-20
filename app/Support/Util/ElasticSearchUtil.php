<?php

namespace App\Support\Util;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Support\Collection;


/**
 * Class ElasticSearchUtil
 * @package NovaConcursos\LibDomain\Domain\Util;
 */
class ElasticSearchUtil
{

    /**
     * @var ClientBuilder $client
     */
    private static $client;


    /**
     * @throws AuthenticationException
     */
    private static function getClient(): Client|ClientBuilder
    {
        if (!self::$client) {
            self::$client = ClientBuilder::create()
                ->setHosts([env('ELASTIC_SEARCH_TLS_HOST', '127.0.0.1:9200')])
                ->build();
        }

        return self::$client;
    }

    /**
     * @throws AuthenticationException
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public static function search(string $index, array $query, array $aggs, int $start, int $size, array $sort = [])
    {
        $client = self::getClient();

        $body = ['size' => $size, 'from' => $start];

        if (count($query) > 0) {
            $body['query'] = $query;
        }
        if (count($aggs) > 0) {
            $body['aggs'] = $aggs;
        }
        if (count($sort) > 0) {
            $body['sort'] = $sort;
        }

        return $client->search([
            'index' => $index,
            'body' => $body
        ]);
    }


    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public static function count(string $index, array $query)
    {
        $client = self::getClient();
        $body = [];
        if (count($query) > 0) {
            $body['query'] = $query;
        }
        return $client->count([
            'index' => $index,
            'body' => $body
        ]);
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public static function update(string $index, int $id, array|Collection $doc, bool $upsert)
    {
        $client = self::getClient();
        $body = [
            'doc' => $doc
        ];
        if ($upsert) {
            $body['upsert'] = $doc;
        }
        return $client->update([
            'index' => $index,
            'id' => $id,
            'body' => $body
        ]);
    }


    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public static function delete(string $index, int $id)
    {
        $client = self::getClient();
        return $client->delete([
            'index' => $index,
            'id' => $id
        ]);
    }


    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public static function deleteIndex(string $index)
    {
        $client = self::getClient();
        return $client->indices()->delete([
            'index' => $index
        ]);
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public static function createIndex(string $index, array $settings, array $mappings)
    {
        $client = self::getClient();
        return $client->indices()->create([
            'index' => $index,
            'body' => ['settings' => $settings, 'mappings' => $mappings]
        ]);
    }
}
