@extends('layout.main')
@section('content')
    <div class="app-content">
        <div class="app-content--inner">
            <div class="pb-4 text-center text-xl-left">
                <div class="row align-items-center">
                    <div class="col-xl-6">
                       <div>
                            <h5 class="title-text mb-1">{{ $title }}</h5>
                             <p class="sub-title-text mb-0">Please see list of {{ strtolower($title) }} below</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-3">
                <div class="card-header">
                    <div class="card-header--title">
                        <div class="row">
                            <div class="col-6">
                                <b>List of {{ $title }}</b>
                            </div>
                        </div>
                    </div>
                </div>
                  
                <table id="example" class="example2 display nowrap table table-hover" width="100%">
                    <thead class="thead">
                        <tr>
                            <th>SNO</th>
                            <th>City name</th>
                            <th>Country Code</th>
                            <th>City id</th>
                            <th>Zone</th>
                        </tr>
                    </thead>
                </table>
            </div>
            
        @section('scripts')
        <script>
            const countries_array = @json($countries);
        </script>
        <script src="{{ asset('assets/js/admin/city-list.js') }}"></script>
        @endsection

    @endsection
