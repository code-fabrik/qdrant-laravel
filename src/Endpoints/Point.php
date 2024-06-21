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

    public function insert(array $ids, array $vectors, array $payloads)
    {
        return $this->client->put("/points?wait=true", [
            'batch' => [
                'ids' => $ids,
                'vectors' => $vectors,
                'payloads' => $payloads,
            ],
        ]);
    }

    public function remove(string $id)
    {
        return $this->client->post("/points/delete?wait=true", [
            'points' => [$id],
        ]);
    }

    public function count() {
        return $this->client->post('/points/count', [
            'exact' => true,
        ]);
    }

    public function all()
    {
        $allPoints = [];
        $offset = null; // Initial offset is null
        $lastOffset = null;

        while (true) {
            $response = $this->client->post("/points/scroll", [
                'offset' => $offset,
                'limit' => 1000,
            ]);

            if (!isset($response['result']['points'])) {
                break;
            }

            $points = $response['result']['points'];

            $allPoints = array_merge($allPoints, $points);

            // Update the offset for the next iteration
            $lastOffset = $offset;
            if (!empty($points)) {
                $offset = end($points)['id'];
            } else {
                break;
            }

            if ($lastOffset === $offset) {
                break;
            }
        }

        return $this->removeDuplicatesById($allPoints);
    }

    private function removeDuplicatesById($arr) {
        $seenIds = [];
        $result = [];

        foreach ($arr as $item) {
            if (!isset($seenIds[$item['id']])) {
                $seenIds[$item['id']] = true;
                $result[] = $item;
            }
        }

        return $result;
    }
}
