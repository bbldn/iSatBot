<?php

namespace App\Formatters;

use Throwable;

class OrderFormatter
{
    /**
     * @param array $order
     * @return string
     */
    public static function formatOrderOnly(array $order): string
    {
        try {
            return (string)view('order', $order);
        } catch (Throwable $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param array $orderProducts
     * @return string[]
     */
    public static function formatOrderProducts(array $orderProducts): array
    {
        $result = [];
        foreach ($orderProducts as $orderProduct) {
            try {
                $view = view('order-product', $orderProduct);
            } catch (Throwable $e) {
                $view = $e->getMessage();
            }
            $result[] = (string)$view;
        }

        return $result;
    }

    /**
     * @param array $order
     * @return array
     */
    public static function formatOrder(array $order): array
    {
        try {
            return [(string)view('order', $order)];
        } catch (Throwable $e) {
            return [$e->getMessage()];
        }
    }
}