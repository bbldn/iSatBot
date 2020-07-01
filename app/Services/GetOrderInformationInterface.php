<?php

namespace App\Services;


interface GetOrderInformationInterface
{
    /**
     * @param int $id
     * @return string[]
     */
    public function getOrderInformation(int $id): array;
}
