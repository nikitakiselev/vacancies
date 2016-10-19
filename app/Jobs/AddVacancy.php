<?php

namespace App\Jobs;

use App\Area;
use App\Vacancy;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Parsers\HeadHunter\Vacancy as HHVacancy;

class AddVacancy implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $areaId;
    /**
     * @var int
     */
    private $vacancyId;

    /**
     * Create a new job instance.
     *
     * @param int $vacancyId
     * @param int $areaId
     */
    public function __construct(int $vacancyId, int $areaId)
    {
        $this->areaId = $areaId;
        $this->vacancyId = $vacancyId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Vacancy::where('external_id', $this->vacancyId)->count() === 0) {
            $vacancy = new HHVacancy($this->vacancyId);

            $area = Area::find($this->areaId);

            $area->vacancies()->create(
                $vacancy->parseInfo()
            );
        }
    }
}
