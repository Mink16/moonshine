@if($value !== false)
    <span class="inline-block rounded-full text-white bg-{{ $color }} px-2 py-1 text-xs font-bold mr-3 text-center">
        {!! $value !!}
    </span>
@else
    &mdash;
@endif