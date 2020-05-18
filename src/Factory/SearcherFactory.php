<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Factory;

use SilverStripe\Core\Injector\Injector;

class SearcherFactory
{
    /**
     * @return SearcherInterface
     */
    public function getSearcher()
    {
        return Injector::inst()->get('FreeTextSearcherImplementation');
    }
}
