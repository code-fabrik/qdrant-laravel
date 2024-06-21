<?php

return [
    'qdrant' => [
        'host' => env('QDRANT_HOST', 'http://localhost'),
        'port' => env('QDRANT_PORT', '6333'),
        'collection' => env('QDRANT_COLLECTION', 'main'),
    ],
];
