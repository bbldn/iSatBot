<?php

namespace App\Services;

use App\Helpers\CustomerEnum;
use Illuminate\Support\Collection;
use App\Formatters\OrderFormatter;
use App\Models\Back\Order as OrderBack;

/**
 * @psalm-type OrderProductPsalm = array{
 *     name: string,
 *     price: string,
 *     number: string,
 *     amount: string,
 *     currency_name: string,
 *     currency_value: string,
 * }
 */
class GetOrderInformationFromBD implements GetOrderInformationInterface
{
    /**
     * @param OrderBack $orderBack
     * @return string|null
     */
    private function getBalance(OrderBack $orderBack): ?string
    {
        foreach ($orderBack->orderValues as $orderValue) {
            if ($orderValue->constId === CustomerEnum::BALANCE) {
                return (string)$orderValue->value;
            }
        }

        return null;
    }

    /**
     * @param OrderBack $orderBack
     * @return array
     *
     * @psalm-return list<OrderProductPsalm>
     */
    protected function getProducts(OrderBack $orderBack): array
    {
        $data = [];

        foreach ($orderBack->orderProducts as $key => $orderProduct) {
            $paymentCurrencyName = null;
            if (null !== $orderProduct->paymentCurrency) {
                $paymentCurrencyName = $orderProduct->paymentCurrency->name;
            }

            $data[] = [
                'number' => (string)($key + 1),
                'name' => (string)$orderProduct->name,
                'price' => (string)$orderProduct->price,
                'amount' => (string)$orderProduct->quantity,
                'currency_name' => (string)$paymentCurrencyName,
                'currency_value' => (string)$orderProduct->payment_currency_value,
            ];
        }

        return $data;
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getOrderInformation(int $id): Collection
    {
        $orderBack = OrderBack::find($id);
        if (null === $orderBack) {
            return collect(['Order not found']);
        }

        $typeName = null;
        if (null !== $orderBack->type) {
            $typeName = $orderBack->type->name;
        }

        $fio = null;
        $phone = null;
        if (null !== $orderBack->customer) {
            $fio = $orderBack->customer->fio;
            $phone = $orderBack->customer->phone;
        }

        $stateName = null;
        if (null !== $orderBack->state) {
            $stateName = $orderBack->state->name;
        }

        $localityName = null;
        if (null !== $orderBack->locality) {
            $localityName = $orderBack->locality->name;
        }

        $warehouseName = null;
        if (null !== $orderBack->warehouse) {
            $warehouseName = $orderBack->warehouse->name;
        }

        $paymentMethodName = null;
        if (null !== $orderBack->paymentMethod) {
            $paymentMethodName = $orderBack->paymentMethod->name;
        }

        $shippingMethodName = null;
        if (null !== $orderBack->shippingMethod) {
            $shippingMethodName = $orderBack->shippingMethod->name;
        }

        $paymentCurrencyName = null;
        if (null !== $orderBack->paymentCurrency) {
            $paymentCurrencyName = $orderBack->paymentCurrency->name;
        }

        $data = [
            'fio' => (string)$fio,
            'phone' => (string)$phone,
            'id' => (int)$orderBack->id,
            'typeName' => (string)$typeName,
            'stateName' => (string)$stateName,
            'email' => (string)$orderBack->email,
            'localityName' => (string)$localityName,
            'address' => (string)$orderBack->address,
            'comment' => (string)$orderBack->comment,
            'warehouseName' => (string)$warehouseName,
            'products' => $this->getProducts($orderBack),
            'paymentMethodName' => (string)$paymentMethodName,
            'balance' => (string)$this->getBalance($orderBack),
            'shippingMethodName' => (string)$shippingMethodName,
            'total' => "{$orderBack->total} {$paymentCurrencyName}",
        ];

        return collect(OrderFormatter::formatOrder($data));
    }
}