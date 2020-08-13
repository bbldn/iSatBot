<strong>Нашли дешевле</strong>

@foreach($data as $value)
    @if (filter_var($value['value'], FILTER_VALIDATE_URL))
{{ $value['name'] }}: <strong><a href="{{ $value['value'] }}">Перейти</a></strong>
    @else
{{ $value['name'] }}: <strong>{{ $value['value'] }}</strong>
    @endif
@endforeach
