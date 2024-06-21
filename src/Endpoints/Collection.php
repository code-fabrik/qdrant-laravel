<?php

declare(strict_types=1);

namespace Codefabrik\QdrantLaravel\Endpoints;

use Codefabrik\QdrantLaravel\QdrantClient;

class Collection
{
    private $client;

    public function __construct(QdrantClient $client)
    {
        $this->client = $client;
    }

    public function exists(): bool
    {
        $data = $this->client->get('/exists');

        return $data['result']['exists'];
    }

    public function create(int $vectorSize, string $distanceMetric)
    {
        return $this->client->put("", [
            'vectors' => [
                'size' => $vectorSize,
                'distance' => $distanceMetric,
            ],
        ]);
    }

    public function delete() {
        return $this->client->delete("");
    }
}
