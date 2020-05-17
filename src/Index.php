<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:27 น.
 */

namespace Suilven\FreeTextSearch;

class Index
{
    /**
     * @var null|\Class the class to index, with namespace
     */
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

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * @param $clazz null|\Class
     */
    public function setClass($clazz)
    {
        $this->clazz = $clazz;
    }

    /**
     * @return null|\Class
     */
    public function getClass()
    {
        return $this->clazz;
    }

    /**
     * @return array<string>
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array<string>
     */
    public function getHasOneFields()
    {
        return $this->hasOneFields;
    }


    /**
     * @return array<string>
     */
    public function getHasManyFields()
    {
        return $this->hasManyFields;
    }

    /**
     * @return array<string>
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Add a full text fieldname to the index
     *
     * @param string $fieldName the name of the field to index
     */
    public function addField($fieldName)
    {
        $this->fields[] = $fieldName;
    }


    /**
     * Add a has one field to the index
     *
     * @param $string fieldName the name of the has one field to index
     */
    public function addHasOneField($fieldName)
    {
        $this->hasOneFields[] = $fieldName;
    }


    /**
     * Add a has many to the index
     *
     * @param string $fieldName the name of the has many field to index
     */
    public function addHasManyField($fieldName)
    {
        $this->hasManyFields[] = $fieldName;
    }

    /**
     * Add a token to the index - not full text searchable but filterable and facetable
     *
     * @param string $token the name of the field to index
     */
    public function addToken($token)
    {
        $this->tokens[] = $token;
    }
}
