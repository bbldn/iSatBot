<strong>Нашли дешевле</strong>

@foreach($data as $key => $value)
@if (true === filter_var($value, FILTER_VALIDATE_URL))
{{ $key }}: <strong><a href="{{ $value }}">Перейти</a></strong>
@elseif (true === $filter($value))
{{ $key }}: {{ $tester($value) }}
@else
{{ $key }}: <strong>{{ $value }}</strong>
@endif
@endforeach
