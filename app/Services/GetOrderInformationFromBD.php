<?php

namespace App\Services;

use App\Models\OrderBack;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Formatters\OrderFormatter;

class GetOrderInformationFromBD implements GetOrderInformationInterface
{
    /**
     * @param int $id
     * @return Collection
     */
    public function getOrderInformation(int $id): Collection
    {
        $ordersBack = OrderBack::where('order_num', $id)->get();
        if (true === $ordersBack->isEmpty()) {
            return collect(['Order not found']);
        }

        /** @var OrderBack $orderBack */
        $orderBack = $ordersBack->first();

        $phone = trim($orderBack->phone);
        if (Str::length($phone) === 0 && $orderBack->client_id > 1) {
            if (null !== $orderBack->customer) {
                $phone = $orderBack->customer->phone;
            }
        }

        $mail = trim($orderBack->mail);
        if (Str::length($mail) === 0 && $orderBack->client_id > 1) {
            if (null !== $orderBack->customer) {
                $mail = $orderBack->customer->mail;
            }
        }

        if (null === $orderBack->shipping) {
            $delivery = 'Неизвестно';
        } else {
            $delivery = $orderBack->shipping->Name;
        }

        if (null === $orderBack->paymentObject) {
            $payment = 'Неизвестно';
        } else {
            $payment = $orderBack->paymentObject->Name;
        }

        if (null === $orderBack->customer) {
            $balance = 'Неизвестно';
        } else {
            $balance = "{$orderBack->customer->balance()}$";
        }

        $data = [
            'id' => $orderBack->order_num,
            'type' => $orderBack->type,
            'FIO' => $orderBack->customer->fio,
            'phone' => $phone,
            'mail' => $mail,
            'region' => $orderBack->region,
            'city' => $orderBack->city,
            'street' => $orderBack->street,
            'house' => $orderBack->house,
            'warehouse' => $orderBack->warehouse,
            'delivery' => $delivery,
            'payment' => $payment,
            'comment' => $orderBack->whant,
            'total' => "{$this->getOrderTotal($ordersBack)} {$orderBack->currency_name}",
            'balance' => $balance,
            'products' => $this->getProducts($ordersBack),
        ];

        return collect(OrderFormatter::formatOrder($data));
    }

    /**
     * @param Collection $orders
     * @return array
     */
    protected function getProducts(Collection $orders): array
    {
        $data = [];

        foreach ($orders as $key => $order) {
            /** @var OrderBack $order */
            $price = round($order->price * $order->currency_value, 2) . ' ' . $order->currency_name;
            $data[] = [
                'number' => $key + 1,
                'name' => $order->product_name,
                'price' => $price,
                'amount' => $order->amount,
                'currency_name' => $order->currency_name,
                'rate' => $order->currency_value,
            ];
        }

        return $data;
    }

    /**
     * @param Collection $orders
     * @return float
     */
    protected function getOrderTotal(Collection $orders): float
    {
        $total = 0;
        foreach ($orders as $key => $order) {
            $total += round($order->price * $order->currency_value, 2);
        }

        return $total;
    }
}