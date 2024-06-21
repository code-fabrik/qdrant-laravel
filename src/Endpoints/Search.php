<?php

declare(strict_types=1);

namespace Codefabrik\QdrantLaravel\Endpoints;

use Codefabrik\QdrantLaravel\QdrantClient;

class Search
{
    private $client;

    public function __construct(QdrantClient $client)
    {
        $this->client = $client;
    }

    public function search(array $vector, mixed $filters = [], ?int $limit = 10, bool $exact = false)
    {
        $body = [
            'vector' => $vector,
            'limit' => $limit,
        ];

        if (count($filters)) {
            $body['filter'] = [
                'must' => []
            ];
        }

        if ($exact) {
            $body['params'] = [
                'exact' => true,
            ];
        }

        foreach ($filters as $key => $value) {
            $body['filter']['must'][] = [
                'key' => $key,
                'match' => [
                    'any' => $value
                ]
            ];
        }

        return $this->client->post("/points/search", $body);
    }
}
