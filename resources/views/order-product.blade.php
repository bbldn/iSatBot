@foreach($products as $product)
    <b>#{{ $product['number'] }}</b>
    <b>Название:</b> {{ $product['name'] }}
    <b>Количество:</b> {{ $product['amount'] }}
    <b>Цена:</b> {{ $product['price'] }}
    <b>Валюта:</b> {{ $product['currency_name'] }}
    <b>Курс:</b> {{ $product['rate'] }}
    \n
@endforeach
