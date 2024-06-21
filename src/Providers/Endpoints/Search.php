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

    public function search(array $documentIds, array $vector, int $limit = 10)
    {
        return $this->client->post("/points/search", [
            'vector' => $vector,
            'limit' => $limit,
            'filter' => [
                'must' => [
                    'key' => 'document_id',
                    'match' => [
                        'any' => $documentIds
                    ]
                ]
            ]
        ]);
    }
}
