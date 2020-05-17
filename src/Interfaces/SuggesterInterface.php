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


interface SuggesterInterface  {

    /**
     * @param $q
     * @param int $limit
     * @return array<string>
     */
    public function suggest($q, $limit = 5);

}
