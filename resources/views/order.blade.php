<b>Новый заказ №{{ $id }}</b>
@include('order-product', ['products' => $products])
<b>Всего:</b> {{ $total }}
<b>Баланс:</b> {{ $balance }}
---------------------------
<b>ФИО:</b> {{ $fio }}
<b>Телефон:</b> {{ $phone }}
<b>E-mail:</b> {{ $email }}
<b>Область:</b> {{ $stateName }}
<b>Город:</b> {{ $localityName }}
<b>Адрес:</b> {{ $address }}
<b>Отделение:</b> {{ $pickUpPointName }}
<b>Доставка:</b> {{ $shippingMethodName }}
<b>Оплата:</b> {{ $paymentMethodName }}
<b>Комментарий:</b> {{ $comment }}
