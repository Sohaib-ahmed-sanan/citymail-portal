{{-- @php
    header('Content-Type: application/pdf');
@endphp
{!! $content !!} --}}


<embed src="data:application/pdf;base64,{{ $content }}" width="100%" height="900px" type="application/pdf">
