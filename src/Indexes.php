<?php declare(strict_types = 1);

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
     *
     * @return array<string, \Suilven\FreeTextSearch\Index> ClassName -> Index
     */
    public function getIndexes(): array
    {
        $indexes = [];

        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes') ;

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


    /** @return array<string> An array of facet fields in lower case, such as ['iso', 'aperture', 'shutterspeed'] */
    public function getFacetFields(string $indexName): array
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name !== $indexName) {
                continue;
            }

            if (!isset($indexConfig['index']['tokens'])) {
                continue;
            }

            foreach ($indexConfig['index']['tokens'] as $token) {
                $result[] = \strtolower($token);
            }
        }

        return $result;
    }


    /** @return array<string> */
    public function getHasOneFields(string $indexName): array
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');

        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name !== $indexName) {
                continue;
            }

            if (!isset($indexConfig['index']['has_one'])) {
                continue;
            }

            foreach ($indexConfig['index']['has_one'] as $hasOne) {
                $result[] = \strtolower($hasOne);
            }
        }

        return $result;
    }


    /** @return array<string> */
    public function getHasManyFields(string $indexName): array
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');

        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name !== $indexName) {
                continue;
            }

            if (!isset($indexConfig['index']['has_many'])) {
                continue;
            }

            foreach ($indexConfig['index']['has_many'] as $hasManyField) {
                $result[] = \strtolower($hasManyField);
            }
        }

        return $result;
    }
}
