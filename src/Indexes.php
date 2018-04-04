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
            foreach($indexConfig['index']['fields'] as $fieldname) {
                $index->addField($fieldname);
            }

            if (isset($indexConfig['index']['tokens'])) {
                foreach($indexConfig['index']['tokens'] as $token) {
                    $index->addToken($token);
                }
            }


            // @todo, relations

            $indexes[] = $index;
        }

        return $indexes;
    }
}
