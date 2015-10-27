<?php

namespace Dgafka\ES\Client\Application\API;

/**
 * Class ClientQuery
 * @package Dgafka\ES\Client\Application\API
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface ClientQuery
{

    /**
     * @return array
     */
    public function getAll();

    /**
     * @param string $id
     *
     * @return array
     */
    public function getById($id);

}