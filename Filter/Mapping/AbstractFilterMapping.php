<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 13:04
 */

namespace BoShurik\AdminBundle\Filter\Mapping;

abstract class AbstractFilterMapping implements FilterMappingInterface
{
    const SUFFIX_FROM = 'From';
    const SUFFIX_TO = 'To';

    /**
     * @var array
     */
    protected $mapping;

    /**
     * @inheritDoc
     */
    public function current()
    {
        return current($this->mapping);
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        next($this->mapping);
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return key($this->mapping);
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return key($this->mapping) !== null;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        reset($this->mapping);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->mapping[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return isset($this->mapping[$offset]) ? $this->mapping[$offset] : null;
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->mapping[] = $value;
        } else {
            $this->mapping[$offset] = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->mapping[$offset]);
    }
}