<?php


namespace Crowdin\Model;

/**
 * Class BaseModel
 * @package Crowdin\Model
 */
class BaseModel implements ModelInterface
{

    /**
     * @var string
     */
    protected $pk = 'id';

    /**
     * Model Data
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new Model instance
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getPk()
    {
        return $this->{$this->pk};
    }

    /**
     * Get the Model data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get Data Property
     *
     * @param  string $property
     *
     * @return mixed
     */
    public function getDataProperty($property)
    {
        return isset($this->data[$property]) ? $this->data[$property] : null;
    }

    /**
     * Handle calls to undefined properties.
     * Check whether an item with the key,
     * same as the property, is available
     * on the data property.
     *
     * @param  string $property
     *
     * @return mixed|null
     */
    public function __get($property)
    {
        if (array_key_exists($property, $this->getData())) {
            return $this->getData()[$property];
        }

        return null;
    }

    /**
     * Handle calls to undefined properties.
     * Sets an item with the defined value
     * on the data property.
     *
     * @param  string $property
     * @param  string $value
     *
     * @return mixed|null
     */
    public function __set($property, $value)
    {
        $this->data[$property] = $value;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return get_object_vars($this);
    }
}