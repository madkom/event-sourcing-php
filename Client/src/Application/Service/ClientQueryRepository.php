<?php

namespace Dgafka\ES\Client\Application\Service;

/**
 * Interface ClientQueryRepository
 * @package Dgafka\ES\Client\Application\Service
 * @author  Dariusz Gafka <d.gafka@madkom.pl>
 */
interface ClientQueryRepository
{

    /**
     * @param string $id
     *
     * @return array
     */
    public function getByID($id);

    /**
     * @return array
     */
    public function getAll();

}