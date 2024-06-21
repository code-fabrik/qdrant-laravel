<?php

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;
use Codefabrik\QdrantLaravel\QdrantClient;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function qdrantSetup()
{
    Config::set('qdrant.host', 'http://qdrant');
    Config::set('qdrant.port', 6333);
    Config::set('qdrant.collection', 'main');

    $qdrant = new QdrantClient();

    try {
        $qdrant->collection()->delete();
    } catch (Exception) { }

    return $qdrant->collection()->create(1024, 'Cosine');
}

function insertFakePoints(int $count) {
    Config::set('qdrant.host', 'http://qdrant');
    Config::set('qdrant.port', 6333);
    Config::set('qdrant.collection', 'main');

    $qdrant = new QdrantClient();

    $ids = [];
    $vectors = [];
    $payloads = [];
    for($i = 0; $i < $count; $i++) {
        $ids[] = generateRandomString(32);
        $vectors[] = generateRandomVector(1024);
        $payloads[] = generateRandomPayload(32);
    }

    return $qdrant->point()->insert($ids, $vectors, $payloads);
}
