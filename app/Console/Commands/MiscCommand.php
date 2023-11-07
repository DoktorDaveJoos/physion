<?php

namespace App\Console\Commands;

use App\Jobs\CreateExposePredictionsJob;
use App\Models\Product\FamilyStrategy;
use Illuminate\Console\Command;

class MiscCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:misc-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {






    }


    public function damnit (...$args) {
        [$yeah, $bye] = $args;

        ray('yeah', $yeah);

        ray('bye', $bye);
    }
}
