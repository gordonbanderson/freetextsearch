<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Factory;

use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use Suilven\ManticoreSearch\Service\Client;


interface SearcherInterface  {
    /**
     * @param array $filters
     */
    public function setFilters($filters);

    /**
     * @param int $pageSize
     */
    public function setPageSize($pageSize);

    /**
     * @param string $indexName
     */
    public function setIndex($indexName);


    /**
     * @param array $facettedTokens
     */
    public function setFacettedTokens($facettedTokens);


    public function search($q);
}
