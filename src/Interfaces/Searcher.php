<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Factory;

interface Searcher
{
    /** @param array $filters */
    public function setFilters(array $filters): void;


    public function setPageSize(int $pageSize): void;


    public function setIndexName(string $indexName): void;


    /** @param array $facettedTokens */
    public function setFacettedTokens(array $facettedTokens): void;


    /** @param array $hasManyTokens */
    public function setHasManyTokens(array $hasManyTokens): void;


    public function setPage(int $pageNumber): void;


    /** @return array */
    public function search(string $q): array;
}
