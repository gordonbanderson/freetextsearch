<?php declare(strict_types = 1);

// @phpcs:disable SlevomatCodingStandard.ControlStructures.EarlyExit.EarlyExitNotUsed

namespace Suilven\FreeTextSearch;

use SilverStripe\Core\Config\Config;

/**
 * Class Indexes
 *
 * @package Suilven\FreeTextSearch
 */
class Indexes
{
    /** @var array<string, \Suilven\FreeTextSearch\Index> */
    private $indexesByName = [];


    /**
     * Get an Index object by name from the config
     */
    public function getIndex(string $name): Index
    {
        if ($this->indexesByName === []) {
            $this->getIndexes();
        }

        return $this->indexesByName[$name];
    }


    /**
     * Get indexes from config
     *
     * @return array<string, \Suilven\FreeTextSearch\Index> ClassName -> Index
     */
    public function getIndexes(): array
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes') ;

        // reset
        $this->indexesByName = [];

        foreach ($indexesConfig as $indexConfig) {
            $name = $indexConfig['index']['name'];
            $indexAlreadyExists = isset($this->indexesByName[$name]);

            // get the existing index, to tweak, or create a new one
            $index = $indexAlreadyExists
                ? $this->indexesByName[$name]
                : new Index();
            $index->setName($name);

            if (isset($indexConfig['index']['class'])) {
                $index->setClass($indexConfig['index']['class']);
            }

            if (isset($indexConfig['index']['fields'])) {
                foreach ($indexConfig['index']['fields'] as $fieldname) {
                    $index->addField($fieldname);
                }
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

            $singleton = \singleton($index->getClass());

            // has many fields
            // NB many many may need to be treated as bipartisan has many
            if (isset($indexConfig['index']['has_many'])) {
                foreach ($indexConfig['index']['has_many'] as $hasManyField) {
                    $relationship = $hasManyField['relationship'];
                    // @phpstan-ignore-next-line
                    $mmList = \call_user_func(array($singleton, $relationship));
                    $index->addHasManyField($hasManyField['name'], [
                        'relationship' => $relationship,
                        'field' => $hasManyField['field'],
                        'class' => $mmList->dataClass(),
                    ]);
                }
            }

            // fields that will be used for highlighting
            if (isset($indexConfig['index']['highlighted_fields'])) {
                foreach ($indexConfig['index']['highlighted_fields'] as $highlightedField) {
                    $index->addHighlightedField($highlightedField);
                }
            }

            // fields that will be used for storage, but not indexed
            if (isset($indexConfig['index']['stored_fields'])) {
                foreach ($indexConfig['index']['stored_fields'] as $storedField) {
                    $index->addStoredField($storedField);
                }
            }

            // tokenizer
            if (isset($indexConfig['index']['tokenizer'])) {
                $index->setTokenizer($indexConfig['index']['tokenizer']);
            }

            $this->indexesByName[$index->getName()] = $index;
        }

        return $this->indexesByName;
    }


    /** @return array<string> An array of facet fields, such as ['ISO', 'Aperture', 'ShutterSpeed'] */
    public function getFacetFields(string $indexName): array
    {
        $indexesConfig = Config::inst()->get('Suilven\FreeTextSearch\Indexes', 'indexes');
        $result = [];
        foreach ($indexesConfig as $indexConfig) {
            $name = ($indexConfig['index']['name']);

            if ($name !== $indexName) {
                continue;
            }

            if (isset($indexConfig['index']['tokens'])) {
                foreach ($indexConfig['index']['tokens'] as $token) {
                    $result[] = $token;
                }
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

            if (isset($indexConfig['index']['has_one'])) {
                foreach ($indexConfig['index']['has_one'] as $hasOne) {
                    $result[] = $hasOne;
                }
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

            if (isset($indexConfig['index']['has_many'])) {
                foreach ($indexConfig['index']['has_many'] as $hasManyField) {
                    $result[] = $hasManyField;
                }
            }
        }

        return $result;
    }
}
