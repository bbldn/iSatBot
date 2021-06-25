<?php

namespace App\Repositories\Back;

use App\Models\Back\Order as OrderBack;

class OrderRepository
{
    /**
     * @param int $id
     * @return OrderBack|null
     */
    public function find(int $id): ?OrderBack
    {
        return OrderBack::find($id);
    }
}