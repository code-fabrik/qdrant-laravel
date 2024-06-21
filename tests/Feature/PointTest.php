<?php

ini_set('memory_limit', '1G');

use Codefabrik\QdrantLaravel\QdrantClient;

function generateRandomString($length = 32) {
    $bytes = random_bytes($length / 2);
    return bin2hex($bytes);
}

function generateRandomVector($length = 32) {
    $vector = array();
    for ($i = 0; $i < $length; $i++) {
        $vector[] = rand();
    }
    return $vector;
}

function generateRandomPayload($key = 'foo') {
    return [
        $key => generateRandomString(12),
    ];
}

test('Insert points', function () {
    qdrantSetup();

    $qdrant = new QdrantClient();
    $result = $qdrant->point()->insert([generateRandomString(32)], [generateRandomVector(1024)], [generateRandomPayload('foo')]);

    expect($result['status'])->toBe('ok');
});

test('Load points', function () {
    qdrantSetup();
    insertFakePoints(2500);

    $qdrant = new QdrantClient();
    $points = $qdrant->point()->all();

    expect(count($points))->toBe(2500);
});

test('Count points', function () {
    qdrantSetup();
    insertFakePoints(123);

    $qdrant = new QdrantClient();
    $count = $qdrant->point()->count();

    expect($count['result']['count'])->toBe(123);
});
