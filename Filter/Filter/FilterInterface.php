<?php
/**
 * User: boshurik
 * Date: 01.03.16
 * Time: 12:39
 */

namespace BoShurik\AdminBundle\Filter\Filter;

interface FilterInterface
{
    /**
     * @param array|null $data
     * @param array|null $order
     * @return mixed
     */
    public function filter(array $data = null, array $order = null);
}