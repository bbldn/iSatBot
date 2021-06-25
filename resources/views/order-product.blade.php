@foreach($products as $product)
--------------------------------
<b>№{{ $product['number'] }}</b>
<b>Название:</b> {{ $product['name'] }}
<b>Количество:</b> {{ $product['quantity'] }}
<b>Цена:</b> {{ $product['price'] }}
<b>Валюта:</b> {{ $product['currency_name'] }}
<b>Курс:</b> {{ $product['currency_value'] }}
@endforeach
