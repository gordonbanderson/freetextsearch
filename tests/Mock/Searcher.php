<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\ArrayList;
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
                $result->setFacets([]);

                $result->setPageSize(10);
                $result->setPage(1);

                $result->setIndex('unit_test_index');
                $result->setSuggestions(['fush']);
        }

        return $result;
    }
}
