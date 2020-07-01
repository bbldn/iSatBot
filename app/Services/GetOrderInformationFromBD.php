<?php

namespace App\Services;

use App\Formatters\OrderFormatter;
use App\OrderBack;

class GetOrderInformationFromBD extends Service implements GetOrderInformationInterface
{
    /**
     * @param int $id
     * @return string[]
     */
    public function getOrderInformation(int $id): array
    {
        $ordersBack = OrderBack::where('order_num', $id)->get();
        if (0 === count($ordersBack)) {
            return ['Order not found'];
        }

        $orderBack = $ordersBack[0];
        $customer = null;

        $phone = trim($orderBack->phone);
//        if (mb_strlen($phone) === 0 && $orderBack->client_id > 1) {
//            $customer = $this->customerBackRepository->find($orderBack->client_id);
//            if (null !== $customer) {
//                $phone = $customer->phone;
//            }
//        }

        $mail = trim($orderBack->mail);
//        if (mb_strlen($mail) === 0 && $orderBack->client_id > 1) {
//            if (null === $customer) {
//                $customer = $this->customerBackRepository->find($orderBack->client_id);
//            }
//
//            if (null !== $customer) {
//                $mail = $customer->mail;
//            }
//        }

        $data = [
            'id' => $orderBack->order_num,
            'type' => $orderBack->type,
            'FIO' => $orderBack->fio,
            'phone' => $phone,
            'mail' => $mail,
            'region' => $orderBack->region,
            'city' => $orderBack->city,
            'street' => $orderBack->street,
            'house' => $orderBack->house,
            'warehouse' => $orderBack->warehouse,
            'delivery' => $this->getDeliveryName($orderBack->delivery),
            'payment' => $this->getPaymentName($orderBack->payment),
            'comment' => $orderBack->getComments(),
            'total' => $this->getOrderTotal($ordersBack) . ' ' . $orderBack->currency_name,
            'balance' => $this->customerBackRepository->getBalanceByCustomerId($orderBack->client_id) . '$',
            'products' => $this->getProducts($ordersBack),
        ];

        return OrderFormatter::formatOrder($data);
    }

    /**
     * @param OrderBack[] $orders
     * @return array
     */
    protected function getProducts(array $orders): array
    {
        $data = [];

        foreach ($orders as $key => $order) {
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
     * @param int $id
     * @return string
     */
    protected function getDeliveryName(int $id): string
    {
        $shippingMethod = $this->shippingMethodBackRepository->find($id);
        if (null !== $shippingMethod) {
            return trim($shippingMethod->name);
        }

        return 'Неизвестно';
    }

    /**
     * @param int $id
     * @return string
     */
    protected function getPaymentName(int $id): string
    {
        $paymentMethod = $this->paymentMethodBackRepository->find($id);
        if (null !== $paymentMethod) {
            return trim($paymentMethod->name);
        }

        return 'Неизвестно';
    }

    /**
     * @param array $orders
     * @return float
     */
    protected function getOrderTotal(array $orders): float
    {
        $total = 0;
        foreach ($orders as $key => $order) {
            $total += round($order->price * $order->currency_value, 2);
        }

        return $total;
    }
}
