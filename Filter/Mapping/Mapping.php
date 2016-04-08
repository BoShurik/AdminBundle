<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 14:42
 */

namespace BoShurik\AdminBundle\Filter\Mapping;

final class Mapping
{
    const BOOLEAN = 'boolean';
    const STRING = 'string';
    const TEXT = 'text';

    const INTEGER = 'integer';
    const INTEGER_FROM = 'integer_from';
    const INTEGER_TO = 'integer_to';

    const FLOAT = 'float';
    const FLOAT_FROM = 'float_from';
    const FLOAT_TO = 'float_to';

    const DATE = 'date';
    const DATE_FROM = 'date_from';
    const DATE_TO = 'date_to';

    const DATETIME = 'datetime';
    const DATETIME_FROM = 'datetime_from';
    const DATETIME_TO = 'datetime_to';

    const TIME = 'time';
    const TIME_FROM = 'time_from';
    const TIME_TO = 'time_to';

    const OBJECT = 'object';

    /**
     * @var string
     */
    private $field;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|null
     */
    private $joinId;

    public function __construct($field, $type, $joinId = null)
    {
        $this->field = $field;
        $this->type = $type;
        $this->joinId = $joinId;
    }

    /**
     * @return mixed
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getJoinId()
    {
        return $this->joinId;
    }
}