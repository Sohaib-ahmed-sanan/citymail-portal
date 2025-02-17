@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            @if ($page_type == 1)
                @include('dashboard.dashboard-view')
            @else
                @include('dashboard.onbording-view')
            @endif
        </div>
    </div>
    </div>
@section('scripts')
    {{-- <script>
        var route = "{{ Route('admin.index') }}"
    </script> --}}
    <script src="{{ asset('assets/js/index.js') }}"></script>
@endsection
@endsection
