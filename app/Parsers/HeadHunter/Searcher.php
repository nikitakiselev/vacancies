<?php

namespace App\Parsers\HeadHunter;

use Illuminate\Support\Collection;
use Symfony\Component\DomCrawler\Crawler;
use App\Parsers\Contracts\SearcherContract;

class Searcher implements SearcherContract
{
    /**
     * @var int
     */
    private $areaId;

    /**
     * @var int
     */
    private $pageNumber;

    /**
     * @var Crawler
     */
    private $crawler;

    /**
     * @var int
     */
    private $itemPerPage;

    /**
     * @param int $areaId hh.ru area id
     * @param int $pageNumber
     * @param int $itemPerPage
     */
    public function __construct(int $areaId, int $pageNumber = 1, int $itemPerPage = 100)
    {
        $this->areaId = $areaId;
        $this->pageNumber = $pageNumber;
        $this->itemPerPage = $itemPerPage;
    }

    /**
     * Get vacancies from current page
     *
     * @return \Illuminate\Support\Collection
     */
    public function search(): Collection
    {
        $this->getContents();

        return collect(
            $this->crawler->filter('.vacancy-serp-item')
                ->each(function (Crawler $crawler) {
                    $url = $crawler->filter('[data-qa="vacancy-serp__vacancy-title"]')->attr('href');
                    $id = $this->extractVacancyIdFromUrl($url);

                    return [
                        'id' => $id,
                        'url' => $url,
                    ];
                })
        );
    }

    /**
     * Check for next page
     *
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->crawler->filter('[data-qa="pager-block"] .HH-Pager-Controls-Next')->count() > 0;
    }

    /**
     * Inc page number
     */
    public function nextPage()
    {
        $this->pageNumber++;
    }

    /**
     * Get current page contents
     *
     * @return $this
     */
    public function getContents()
    {
        $url = $this->getCurrentPageUrl();

        $this->crawler = new Crawler(file_get_contents($url));

        return $this;
    }

    /**
     * Extract vacancy id from its url
     *
     * @param $url
     * @return integer
     */
    public static function extractVacancyIdFromUrl($url): int
    {
        $path = parse_url($url, PHP_URL_PATH);

        $parts = explode('/', $path);

        return (int)array_pop($parts);
    }

    /**
     * Get the current page number
     *
     * @return int
     */
    public function currentPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * Get current page url
     *
     * @return string
     */
    protected function getCurrentPageUrl(): string
    {
        return "https://hh.ru/search/vacancy?" . http_build_query([
            'area' => $this->areaId,
            'page' => $this->pageNumber - 1,
            'items_on_page' => $this->itemPerPage,
        ]);
    }
}
