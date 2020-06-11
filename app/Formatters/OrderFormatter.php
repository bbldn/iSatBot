<?php

namespace App\Formatters;

use Throwable;

class OrderFormatter extends Formatter
{
    /**
     * @param array $order
     * @return string
     */
    public static function formatOrderOnly(array $order): string
    {
        try {
            return view('order.blade.php', $order);
        } catch (Throwable $e) {
            return $e->getMessage();
        }//
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
                $view = view('order-product.blade.php', $orderProduct);
            } catch (Throwable $e) {
                $view = $e->getMessage();
            }
            $result[] = $view;
        }

        return $result;
    }

    /**
     * @param array $order
     * @return array
     */
    public static function formatOrder(array $order): array
    {
        return array_merge([static::formatOrderOnly($order), 'Товары:'], static::formatOrderProducts($order['products']));
    }
}
