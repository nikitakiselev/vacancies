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
            'external_id' => $this->vacancyId,
            'url' => $url,
            'title' => $this->getInfo($crawler, '[data-qa="vacancy-title"]'),
            'company' => $this->getInfo($crawler, '[data-qa="vacancy-company"]'),
            'experience' => $this->getInfo($crawler, '[data-qa="vacancy-experience"]'),
            'description' => $this->getInfo($crawler, '[data-qa="vacancy-description"]'),
            'employment_mode' => $this->getInfo($crawler, '[data-qa="vacancy-view-employment-mode"]'),
        ];
    }

    protected function getInfo($crawler, $selector): string
    {
        return $crawler->filter($selector)->count()
            ? $crawler->filter($selector)->text()
            : '';
    }

}
