<b>Новый заказ №{{ $id }}</b>
@include('order-product', ['products' => $products])
<b>Всего:</b> {{ $total }}
---------------------------
<b>Тип:</b> {{ $type }}
<b>ФИО:</b> {{ $FIO }}
<b>Телефон:</b> {{ $phone }}
<b>E-mail:</b> {{ $mail }}
<b>Область:</b> {{ $region }}
<b>Город:</b> {{ $city }}
<b>Улица:</b> {{ $street }}
<b>Дом:</b> {{ $house }}
<b>Отделение:</b> {{ $warehouse }}
<b>Доставка:</b> {{ $delivery }}
<b>Оплата:</b> {{ $payment }}
<b>Комментарий:</b> {{ $comment }}
