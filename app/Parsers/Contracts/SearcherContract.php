<?php

namespace App\Parsers\Contracts;

use Illuminate\Support\Collection;

interface SearcherContract
{
    /**
     * Search vacancies on page
     *
     * @return Collection
     */
    public function search(): Collection;

    /**
     * Check for next page
     *
     * @return bool
     */
    public function hasNextPage(): bool;

    /**
     * Inc page number
     *
     * @return mixed
     */
    public function nextPage();

    /**
     * Get current page number
     *
     * @return int
     */
    public function currentPageNumber(): int;
}
