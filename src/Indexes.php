<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:51 น.
 */

namespace Suilven\FreeTextSearch;


use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;

class Indexes
{
    /**
     * Get indexes from config
     * @return array ClassName -> Index
     *
     * // @todo possibly remove the override as it breaks the searcher
     */
    public function getIndexes($indexesOverride = null)
    {
        $indexes = [];

        $indexesConfig = empty($indexesOverride) ?
            Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes') : $indexesOverride;

        error_log('INDEXES CONFIG: ' . print_r($indexesConfig, 1));

        error_log('IS TEST? ' . Director::isTest());

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
