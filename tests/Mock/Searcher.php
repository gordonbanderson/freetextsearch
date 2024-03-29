<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Container\SearchResults;

class Searcher extends \Suilven\FreeTextSearch\Base\Searcher
{
    /** @return array<string,array<string,string>> */
    public function search(?string $q): SearchResults
    {
        $result = new SearchResults();
        switch ($q) {
            case 'Fish':
                $records = [
                    [
                        'Title' => 'Fishing in New Zealand',
                    ],
                ];
                $recordsList = new ArrayList($records);
                $result->setRecords($recordsList);

                $result->setTime(0.017);

                $result->setPageSize(10);
                $result->setPage(1);

                $result->setIndexName('unit_test_index');
                $result->setSuggestions(['fush']);


                $highlights = ['Title' => [
                    '<b>Fish</b>ing in New Zealand',
                    ],
                ];

                $result->Highlights = $highlights;
        }

        return $result;
    }


    /** @param \SilverStripe\ORM\DataObject $dataObject a dataObject relevant to the index */
    public function searchForSimilar(DataObject $dataObject): SearchResults
    {
        return $this->search('Fish');
    }
}
