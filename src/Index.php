<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:27 น.
 */

namespace Suilven\FreeTextSearch;

use Suilven\FreeTextSearch\Types\LanguageTypes;
use Suilven\FreeTextSearch\Types\TokenizerTypes;

class Index
{
    /** @var string the name of the class to index, with namespace */
    private $clazz = '';

    /** @var array<string> names of fields */
    private $fields = [];

    /** @var array<string> names of stored fields */
    private $storedFields = [];

    /** @var array<string> names of tokens */
    private $tokens = [];

    /** @var array<string,array<string,string>> names of has one fields, with other info */
    private $hasOneFields = [];

    /** @var array<string,array<string,string>> names of has many fields, with other info */
    private $hasManyFields = [];

    /** @var array<string> names of highlighted fields */
    private $highlightedFields = [];

    /** @var string the name of the index */
    private $name;

    /** @var string the tokenizer flag */
    private $tokenizer = TokenizerTypes::NONE;

    // @TODO allow for multiple languages?

    /** @var string the language code */
    private $language = LanguageTypes::ENGLISH;

    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function setClass(string $clazz): void
    {
        $this->clazz = $clazz;
    }


    public function getClass(): string
    {
        return $this->clazz;
    }


    /** @return array<string> */
    public function getFields(): array
    {
        return $this->fields;
    }


    /** @return array<string> */
    public function getStoredFields(): array
    {
        return $this->storedFields;
    }


    /** @return array<string> */
    public function getHighlightedFields(): array
    {
        return $this->highlightedFields;
    }


    /** @return array<string,array<string,string>> */
    public function getHasOneFields(): array
    {
        return $this->hasOneFields;
    }


    /** @return array<string,array<string,string>> */
    public function getHasManyFields(): array
    {
        return $this->hasManyFields;
    }


    /** @return array<string> */
    public function getTokens(): array
    {
        return $this->tokens;
    }


    public function getTokenizer(): string
    {
        return $this->tokenizer;
    }


    public function getLanguage(): string
    {
        return $this->language;
    }


    /**
     * Add a full text fieldname to the index
     *
     * @param string $fieldName the name of the field to index
     */
    public function addField(string $fieldName): void
    {
        $this->fields[] = $fieldName;
    }


    /**
     * Register a field to be used for the purposes of highlighting
     *
     * @param string $fieldName the name of the field to index
     */
    public function addHighlightedField(string $fieldName): void
    {
        $this->highlightedFields[] = $fieldName;
    }


    /**
     * Add a stored field to the index. This is not indexed for free text search, but it used for convenience when
     * rendering search results. e.g. the thumbnail URL for a third party image service
     *
     * @param string $fieldName the name of the field to index
     */
    public function addStoredField(string $fieldName): void
    {
        $this->storedFields[] = $fieldName;
    }


    /**
     * Add a has one field to the index
     *
     * @param string $name the name of the has many field to index
     * @param array<string,string> $relationshipNameAndValueField */
    public function addHasOneField(string $name, array $relationshipNameAndValueField): void
    {
        $this->hasOneFields[$name] = $relationshipNameAndValueField ;
    }


    /**
     * Add a has many to the index
     *
     * @param string $name the name of the has many field to index
     * @param array<string,string> $relationshipNameAndValueField
     */
    public function addHasManyField(string $name, array $relationshipNameAndValueField): void
    {
        $this->hasManyFields[$name] = $relationshipNameAndValueField ;
    }


    /**
     * Add a token to the index - not full text searchable but filterable and facetable
     *
     * @param string $token the name of the field to index
     */
    public function addToken(string $token): void
    {
        $this->tokens[] = $token;
    }


    public function setTokenizer(string $newTokenizer): void
    {
        $this->tokenizer = $newTokenizer;
    }
}
