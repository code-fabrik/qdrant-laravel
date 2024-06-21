<?php

declare(strict_types=1);

namespace Codefabrik\QdrantLaravel;

use Codefabrik\QdrantLaravel\Endpoints\Collection;
use Codefabrik\QdrantLaravel\Endpoints\Point;
use Codefabrik\QdrantLaravel\Endpoints\Search;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class QdrantClient
{
    private $qdrantHost;
    private $qdrantPort;
    private $qdrantCollection;

    public function __construct()
    {
        $this->qdrantHost = Config::get('qdrant.host', 'http://localhost');
        $this->qdrantPort = Config::get('qdrant.port', 6333);
        $this->qdrantCollection = Config::get('qdrant.collection', 'main');
    }

    public function collection()
    {
        return new Collection($this);
    }

    public function point()
    {
        return new Point($this);
    }

    public function search()
    {
        return new Search($this);
    }

    public function get(string $path)
    {
        return $this->request('get', $path);
    }

    public function post(string $path, $body)
    {
        return $this->request('post', $path, $body);
    }

    public function put(string $path, $body)
    {
        return $this->request('put', $path, $body);
    }

    private function request(string $method, string $path, $body = null)
    {
        $response = Http::$method("{$this->qdrantHost}:{$this->qdrantPort}/collections/{$this->qdrantCollection}{$path}", $body);
        $response->throw();
        $data = $response->json();

        return $data;
    }
}
