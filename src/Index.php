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
     * @var null|Class the class to index, with namespace
     */
    private $clazz = null;

    private $fields = [];
    private $tokens = [];

    private $hasOneFields = [];
    private $hasManyFields = [];

    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /*
     *  public function init()
    {
        $this->addClass(Page::class);
        $this->addFulltextField('Title');
        $this->addFulltextField('Content');
    }
     */

    public function setClass($clazz)
    {
        $this->clazz = $clazz;
    }

    /**
     * @return null|Class
     */
    public function getClass()
    {
        return $this->clazz;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function getHasOneFields()
    {
        return $this->hasOneFields;
    }


    public function getHasManyFields()
    {
        return $this->hasManyFields;
    }

    /**
     * @return array
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Add a full text fieldname to the index
     *
     * @param $fieldName the name of the field to index
     */
    public function addField($fieldName)
    {
        $this->fields[] = $fieldName;
    }


    /**
     * Add a has one field to the index
     *
     * @param $fieldName the name of the has one field to index
     */
    public function addHasOneField($fieldName)
    {
        $this->hasOneFields[] = $fieldName;
    }


    /**
     * Add a has many to the index
     *
     * @param $fieldName the name of the has many field to index
     */
    public function addHasManyField($fieldName)
    {
        $this->hasManyFields[] = $fieldName;
    }

    /**
     * Add a token to the index - not full text searchable but filterable and facetable
     *
     * @param $token the name of the field to index
     */
    public function addToken($token)
    {
        $this->tokens[] = $token;
    }
}
