<?php

namespace Codefabrik\QdrantLaravel\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Codefabrik\QdrantLaravel\QdrantClient;

class QdrantSetup extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qdrant:setup {vector_dimensions : the dimensions of the embedding vector, e.g. 1024} {distance_metric : the distance metric for querying, e.g. Cosine}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the Qdrant colleciton if necessary';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dimensions = $this->argument('vector_dimensions');
        $metric = $this->argument('distance_metric');

        $qdrant = new QdrantClient();
        if($qdrant->collection()->exists()) {
            $this->info("Collection already exists.");
            return 0;
        }
        $qdrant->collection()->create($dimensions, $metric);
        $this->info("Collection was created.");
    }
}
