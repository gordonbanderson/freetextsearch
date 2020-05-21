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
     *
     */
    public function getIndexes()
    {
        $indexes = [];
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        foreach ($indexesConfig as $indexConfig) {
            $index = new Index();
            $index->setClass($indexConfig['index']['class']);
            $index->setName($indexConfig['index']['name']);
            foreach ($indexConfig['index']['fields'] as $fieldname) {
                $index->addField($fieldname);
            }

            if (isset($indexConfig['index']['tokens'])) {
                foreach ($indexConfig['index']['tokens'] as $token) {
                    $index->addToken($token);
                }
            }

            // has one fields
            if (isset($indexConfig['index']['has_one'])) {
                foreach ($indexConfig['index']['has_one'] as $hasOneField) {
                    $index->addHasOneField($hasOneField);
                }
            }

            // has many fields
            // NB many many may need to be treated as bipartisan has many
            if (isset($indexConfig['index']['has_many'])) {
                foreach ($indexConfig['index']['has_many'] as $hasManyField) {
                    $index->addHasManyField($hasManyField);
                }
            }

            $indexes[] = $index;
        }

        return $indexes;
    }


    /**
     * @param string $indexName
     * @return array<string> An array of facet fields in lower case, such as ['iso', 'aperture', 'shutterspeed']
     */
    public function getFacetFields($indexName)
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        error_log('getFacetFields');
        error_log(print_r($indexesConfig));

        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name == $indexName) {
                if (isset($indexConfig['index']['tokens'])) {
                    foreach ($indexConfig['index']['tokens'] as $token) {
                        //$result[] = strtolower($token);
                        $result[] = $token;
                    }
                }
            }
        }

        return $result;
    }


    /**
     * @param string $indexName
     * @return array<string>
     */
    public function getHasOneFields($indexName)
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name == $indexName) {
                if (isset($indexConfig['index']['has_one'])) {
                    foreach ($indexConfig['index']['has_one'] as $hasOne) {
                        //$result[] = strtolower($hasOne);
                        $result[] = $hasOne;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * @param string $indexName
     * @return array<string>
     */
    public function getHasManyFields($indexName)
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name == $indexName) {
                if (isset($indexConfig['index']['has_many'])) {
                    foreach ($indexConfig['index']['has_many'] as $hasManyField) {
                        //$result[] = strtolower($hasManyField);
                        $result[] = $hasManyField;
                    }
                }
            }
        }

        return $result;
    }
}
