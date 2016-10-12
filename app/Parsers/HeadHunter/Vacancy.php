<?php

namespace App\Parsers\HeadHunter;

use Symfony\Component\DomCrawler\Crawler;

class Vacancy
{
    /**
     * @var int
     */
    private $vacancyId;

    /**
     * @param int $vacancyId
     */
    public function __construct(int $vacancyId)
    {
        $this->vacancyId = $vacancyId;
    }

    /**
     * Parse vacancy info prom page
     *
     * @return array
     */
    public function parseInfo(): array
    {
        $url = "https://hh.ru/vacancy/" . $this->vacancyId;

        $contents = file_get_contents($url);

        $crawler = new Crawler($contents);

        return [
            'id' => $this->vacancyId,
            'url' => $url,
            'title' => $crawler->filter('.b-vacancy-title')->text(),
            'company' => $crawler->filter('.companyname > a')->text(),
            'experience' => $crawler->filter('.b-vacancy-info [itemprop="experienceRequirements"]')->text(),
            'description' => $crawler->filter('.b-vacancy-desc-wrapper')->text(),
            'employment_mode' => $crawler->filter('.b-vacancy-employmentmode [itemprop="workHours"]')->text(),
        ];
    }
}
