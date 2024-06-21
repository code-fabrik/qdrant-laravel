<?php

use Illuminate\Support\Facades\Config;
use Codefabrik\QdrantLaravel\QdrantClient;

test('Create collection', function () {
    qdrantSetup();

    $qdrant = new QdrantClient();

    $qdrant->collection()->delete();

    $exists = $qdrant->collection()->exists();
    expect($exists)->toBe(false);

    $qdrant->collection()->create(1024, 'Cosine');

    $exists = $qdrant->collection()->exists();
    expect($exists)->toBe(true);
});
