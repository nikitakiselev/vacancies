<?php

namespace App\Console\Commands;

use App\Area;
use App\Vacancy;
use App\Jobs\AddVacancy;
use Illuminate\Console\Command;
use App\Parsers\HeadHunter\Searcher;

class ParseVacancies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hh:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse vacancies from https://hh.ru';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $start = microtime(true);

        $areas = Area::all();

        foreach ($areas as $area) {
            $this->line("Parsing area: {$area->name} ({$area->hh_area_id})");

            $searcher = new Searcher($area->hh_area_id);

            do {
                $this->line("Current page number: {$searcher->currentPageNumber()}.");

                $searcher->search()->each(function ($result) use ($area) {
                    if (Vacancy::where('external_id', $result['id'])->count() === 0) {
                        dispatch(new AddVacancy($result['id'], $area->id));
                    }
                });

                $searcher->nextPage();

            } while ($searcher->hasNextPage());
        }

        $time_elapsed = round((microtime(true) - $start) / 60);

        $this->line("Work done for {$time_elapsed} minute(s).");
    }
}
