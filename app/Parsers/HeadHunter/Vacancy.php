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
            'title' => $this->getInfo($crawler, '.b-vacancy-title'),
            'company' => $this->getInfo($crawler, '.companyname > a'),
            'experience' => $this->getInfo($crawler, '.b-vacancy-info [itemprop="experienceRequirements"]'),
            'description' => $this->getInfo($crawler, '.b-vacancy-desc-wrapper'),
            'employment_mode' => $this->getInfo($crawler, '.b-vacancy-employmentmode [itemprop="workHours"]'),
        ];
    }

    protected function getInfo($crawler, $selector): string
    {
        return $crawler->filter($selector)->count()
            ? $crawler->filter($selector)->text()
            : '';
    }

}
