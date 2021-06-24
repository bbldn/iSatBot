<?php

namespace App\Services;

use Illuminate\Support\Collection;

interface GetOrderInformationInterface
{
    /**
     * @param int $id
     * @return Collection
     */
    public function getOrderInformation(int $id): Collection;
}