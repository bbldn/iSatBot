<strong>Нашли дешевле</strong>

@foreach($data as $key => $value)
@if (filter_var($value, FILTER_VALIDATE_URL))
{{ $key }}: <strong><a href="{{ $value }}">Перейти</a></strong>
@elseif ($tester($value))
{{ $key }}: {{ $filter($value) }}
@else
{{ $key }}: <strong>{{ $value }}</strong>
@endif
@endforeach
