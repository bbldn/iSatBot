<?php

namespace App\Services;

use App\Formatters\OrderFormatter;
use Illuminate\Support\Collection;

class GetOrderInformationFromAPI implements GetOrderInformationInterface
{
    /**
     * @param int $id
     * @return Collection
     */
    public function getOrderInformation(int $id): Collection
    {
        $response = file_get_contents(env('API_URL') . '/api/order/back/information/' . $id);

        if (false === $response) {
            return collect(['Сервер недоступен']);
        }

        $response = json_decode($response, true);

        if (false === $response) {
            return collect(['Сервер вернул не правильный ответ']);
        }

        if (false === $response['ok']) {
            return collect(['Сервер вернул ошибку:']);
        }

        return collect(OrderFormatter::formatOrder($response['data']));
    }
}