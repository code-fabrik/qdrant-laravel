<?php

declare(strict_types=1);

namespace Codefabrik\QdrantLaravel\Endpoints;

use Codefabrik\QdrantLaravel\QdrantClient;

class Point
{
    private $client;

    public function __construct(QdrantClient $client)
    {
        $this->client = $client;
    }

    public function insert(string $id, array $vector, array $payload)
    {
        return $this->client->put("/points?wait=true", [
            'batch' => [
                'ids' => [$id],
                'vectors' => [$vector],
                'payloads' => [$payload]
            ],
        ]);
    }

    public function remove(string $id)
    {
        return $this->client->post("/points/delete?wait=true", [
            'points' => [$id],
        ]);
    }

    public function all()
    {
        $allPoints = [];
        $offset = null;
        $lastOffset = null;

        while (true) {
            $points = $this->client->post("/points/scroll", [ 'offset' => $offset, 'limit' => 1000, ])['result']['points'];

            $allPoints = array_merge($allPoints, $points);

            $offset = end($points)['id'];

            if ($lastOffset == $offset) {
                break;
            }

            $lastOffset = $offset;
        }

        return $allPoints;
    }
}
