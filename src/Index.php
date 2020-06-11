<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:27 น.
 */

namespace Suilven\FreeTextSearch;

class Index
{
    /** @var string|null the name of the class to index, with namespace */
    private $clazz = null;

    /** @var array<string> names of fields */
    private $fields = [];

    /** @var array<string> names of tokens */
    private $tokens = [];

    /** @var array<string> names of has one fields */
    private $hasOneFields = [];

    /** @var array<string> names of has many fields */
    private $hasManyFields = [];

    /** @var string the name of the index */
    private $name;

    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function setClass(?string $clazz): void
    {
        $this->clazz = $clazz;
    }


    public function getClass(): ?string
    {
        return $this->clazz;
    }


    /** @return array<string> */
    public function getFields(): array
    {
        return $this->fields;
    }


    /** @return array<string> */
    public function getHasOneFields(): array
    {
        return $this->hasOneFields;
    }


    /** @return array<string> */
    public function getHasManyFields(): array
    {
        return $this->hasManyFields;
    }


    /** @return array<string> */
    public function getTokens(): array
    {
        return $this->tokens;
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
     * Add a has one field to the index
     *
     * @param string $fieldName the name of the has one field to index
     */
    public function addHasOneField(string $fieldName): void
    {
        $this->hasOneFields[] = $fieldName;
    }


    /**
     * Add a has many to the index
     *
     * @param string $fieldName the name of the has many field to index
     */
    public function addHasManyField(string $fieldName): void
    {
        $this->hasManyFields[] = $fieldName;
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
}
