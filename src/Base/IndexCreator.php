<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Indexes;

abstract class IndexCreator implements \Suilven\FreeTextSearch\Interfaces\IndexCreator
{
    /**
     * (Re)create an index of the given name, using the index configuration from YML
     *
     * @param string $indexName The name of the index
     * @todo Tidy up this method in conjunction with manticore search module
     */
    public function createIndex(string $indexName): void
    {
        $indexes = new Indexes();
        $indice = $indexes->getIndex($indexName);


        $clazz = $indice->getClass();
        $instance = DataObject::singleton($clazz);
        $classes = $instance->getClassAncestry();

        // @todo Fix this class
        \error_log(\print_r($classes, true));
        /*
        foreach ($classes as $indiceClass) {
            $fields = $indice->getFields();
        }
        */
    }
}
