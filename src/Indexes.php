<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:51 น.
 */

namespace Suilven\FreeTextSearch;


use SilverStripe\Core\Config\Config;

class Indexes
{
    /**
     * Get indexes from config
     * @return array ClassName -> Index
     */
    public function getIndexes()
    {
        $indexes = [];

        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        foreach($indexesConfig as $indexConfig)
        {
            error_log('--- index config ----');
            error_log(print_r($indexConfig, 1));
            $index = new Index();
            $index->setClass($indexConfig['index']['class']);
            $index->setName($indexConfig['index']['name']);
            foreach($indexConfig['index']['fields'] as $fieldConfig) {
                $index->addFulltextField($fieldConfig['name']);
            }
            $indexes[] = $index;
        }

        return $indexes;
    }
}
