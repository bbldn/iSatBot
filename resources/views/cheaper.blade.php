<strong>Нашли дешевле</strong>

@foreach($data as $value)
@if (filter_var($value['value'], FILTER_VALIDATE_URL))
{{ $value['name'] }}: <strong><a href="{{ $value['value'] }}">Перейти</a></strong>
@elseif (1 === preg_match('/^38 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/', $value['value']))
{{ $value['name'] }}: <strong><a href="tel:{{ $value['value'] }}">{{ $value['value'] }}</a></strong>
@else
{{ $value['name'] }}: <strong>{{ $value['value'] }}</strong>
@endif
@endforeach
