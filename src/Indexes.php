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

        foreach($indexesConfig as $indexConfig)
        {
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

            // has one fields
            if (isset($indexConfig['index']['has_one'])) {
                foreach($indexConfig['index']['has_one'] as $hasOneField) {
                    $index->addHasOneField($hasOneField);
                }
            }

            // has many fields
            // NB many many may need to be treated as bipartisan has many
            if (isset($indexConfig['index']['has_many'])) {
                foreach($indexConfig['index']['has_many'] as $hasManyField) {
                    $index->addHasManyField($hasManyField);
                }
            }

            $indexes[] = $index;
        }

        return $indexes;
    }


    /**
     * @param $indexName
     * @return array An array of facet fields in lower case, such as ['iso', 'aperture', 'shutterspeed']
     */
    public function getFacetFields($indexName)
    {
        $indexesConfig = empty($indexesOverride) ?
            Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes') : $indexesOverride;
        $result = [];
        foreach($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name == $indexName) {
                if (isset($indexConfig['index']['tokens'])) {
                    foreach($indexConfig['index']['tokens'] as $token) {
                        $result[] = strtolower($token);
                    }
                }
            }
        }

        return $result;
    }


    public function getHasOneFields($indexName)
    {
        $indexesConfig = empty($indexesOverride) ?
            Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes') : $indexesOverride;
        $result = [];
        foreach($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name == $indexName) {
                if (isset($indexConfig['index']['has_one'])) {
                    foreach($indexConfig['index']['has_one'] as $hasOne) {
                        $result[] = strtolower($hasOne);
                    }
                }
            }
        }

        return $result;
    }


    public function getHasManyFields($indexName)
    {
        $indexesConfig = empty($indexesOverride) ?
            Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes') : $indexesOverride;
        $result = [];
        foreach($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name == $indexName) {
                if (isset($indexConfig['index']['has_many'])) {
                    foreach($indexConfig['index']['has_many'] as $hasManyField) {
                        $result[] = strtolower($hasManyField);
                    }
                }
            }
        }

        return $result;
    }
}
