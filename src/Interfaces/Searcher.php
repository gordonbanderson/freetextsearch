<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Factory;

/**
 * Interface Searcher
 *
 * @package Suilven\FreeTextSearch\Factory
 * @todo Fix this once output format decided upon
 *
 * @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

 */
interface Searcher
{
    /** @param array<string,string> $filters */
    public function setFilters(array $filters): void;


    /** @param int $pageSize the number of results to return */
    public function setPageSize(int $pageSize): void;


    public function setIndexName(string $indexName): void;


    /** @param array<string,string> $facettedTokens */
    public function setFacettedTokens(array $facettedTokens): void;


    /** @param array<string> $hasManyTokens */
    public function setHasManyTokens(array $hasManyTokens): void;


    /** @param int $pageNumber the page number of results to return */
    public function setPage(int $pageNumber): void;


    /**
     * @param string $q the search query
     * @todo Fix annotation
     * @return array<string,array>
     */
    public function search(string $q): array;
}