<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Container\SearchResults;

//@phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification
interface Searcher
{
    /** @param array<string,string|int|float|bool> $filters */
    public function setFilters(array $filters): void;


    /** @param int $pageSize the number of results to return */
    public function setPageSize(int $pageSize): void;


    /** Set the index name */
    public function setIndexName(string $indexName): void;


    /** @param array<string,string> $facettedTokens */
    public function setFacettedTokens(array $facettedTokens): void;


    /** @param array<string> $hasManyTokens */
    public function setHasManyTokens(array $hasManyTokens): void;


    /** @param int $pageNumber the page number of results to return */
    public function setPage(int $pageNumber): void;


    /** @param string $q the search query */
    public function search(?string $q): SearchResults;


    /** @param \SilverStripe\ORM\DataObject $dataObject a dataObject relevant to the index */
    public function searchForSimilar(DataObject $dataObject): SearchResults;
}
