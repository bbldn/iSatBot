<?php

namespace App\Services;

use App\Formatters\OrderFormatter;

class OrderService extends Service
{
    /**
     * @param int $id
     * @return array
     */
    public function getOrderInformation(int $id): array
    {
        $response = file_get_contents(env('API_URL') . '/api/order/back/information/' . $id);
        $response = json_encode($response);

        if (false === $response) {
            return ['Сервер вернул ошибку'];
        }

        if (false === $response['ok']) {
            return ['Сервер вернул ошибку'];
        }

        return OrderFormatter::formatOrder($response);
    }
}
