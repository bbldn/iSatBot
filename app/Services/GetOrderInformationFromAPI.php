<?php

namespace App\Services;

use App\Formatters\OrderFormatter;

class GetOrderInformationFromAPI extends Service implements GetOrderInformationInterface
{
    /**
     * @param int $id
     * @return string[]
     */
    public function getOrderInformation(int $id): array
    {
        $response = file_get_contents(env('API_URL') . '/api/order/back/information/' . $id);

        if (false === $response) {
            return ['Сервер недоступен'];
        }

        $response = json_decode($response, true);

        if (false === $response) {
            return ['Сервер вернул не правильный ответ'];
        }

        if (false === $response['ok']) {
            return ['Сервер вернул ошибку:'];
        }

        return OrderFormatter::formatOrder($response['data']);
    }
}
