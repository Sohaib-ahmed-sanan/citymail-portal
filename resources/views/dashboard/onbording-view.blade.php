<div class="pb-4 text-center text-xl-left">
    <div class="row">
        <div class="col-xl-7">
            <div>
                <ol class="d-inline-block breadcrumb text-uppercase font-size-xs p-0">
                    <li class="d-inline-block breadcrumb-item"><a href="/home">Dashboard</a></li>
                </ol>
                <h5 class="display-4 mt-1 mb-2 font-weight-bold">DASHBOARD -
                    {{ is_ops() ? 'ADMIN PORTAL' : 'CUSTOMER PORTAL' }}</h5>
                <p class="text-black-50 mb-0">Welcome To Orio Express</p>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md-6">
        <div class="card card-box d-block">
            <div class="card-header bg-light">
                <div class="card-header--title">
                    <h5 class="mb-0">Use Orio Express With Your Own shipping Accounts</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-center">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</p>
                            </div>
                            <div class="col-12 text-center">
                                <a href="#" class="btn btn-orio">Add Courier</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="oriopay-onboarding" id="oriopay-onboarding">

    <div class="row">
        <div class="col-lg-6">
            <div class="card card-box d-block ">
                <div class="card-header bg-light">
                    <div class="card-header--title">
                        <b>
                            <h6 class="mb-0">Use ORIO with your own shipping accounts</h6>
                        </b>
                    </div>
                </div>

                <div class="card-body pb-0">
                    <div class="row justify-content-center no-gutters onboarding-logos-body">
                        @foreach ($couriers as $courier)
                            @if ($courier->id != '11' && $courier->id != '12')
                                <div
                                    class="col-md-2 col-6 text-center p-2 d-flex justify-content-center align-items-center ">
                                    <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                        data-toggle="tooltip" title="{{ $courier->courier_name }}">
                                        <div><img
                                                src="{{ asset('images/default/couriers/' . $courier->courier_name . '.svg') }}"
                                                width="70" alt="{{ $courier->courier_name }}"></div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="card-footer border-0">
                    <div class="row justify-content-center no-gutters">
                        <div class="col-lg-12 text-center py-3">
                            <a href="{{ route('admin.couriers') }}" class="btn btn-primary">Start here by adding your
                                shipping account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-box d-block ">
                <div class="card-header bg-light">

                    <div class="card-header--title">
                        <b>
                            <h6 class="mb-0">Complete your profile</h6>
                        </b>
                    </div>

                </div>

                <div class="card-body pb-0">

                    <div class="row justify-content-center no-gutters onboarding-logos-body">

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="BlueX Managed">

                                <div><img src="{{ asset('images/default/couriers/prefered-logo-1.svg') }}"
                                        width="100" alt="BlueX Managed"></div>

                            </a>

                        </div>

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="TCS Managed">

                                <div><img src="{{ asset('images/default/couriers/prefered-logo-2.svg') }}"
                                        width="100" alt="TCS Managed"></div>

                            </a>

                        </div>

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="Leopard Managed">

                                <div><img src="{{ asset('images/default/couriers/prefered-logo-3.svg') }}"
                                        width="100" alt="Leopard Managed"></div>

                            </a>

                        </div>

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="Trax Managed">

                                <div><img src="{{ asset('images/default/couriers/prefered-logo-7.svg') }}"
                                        width="100" alt="Trax Managed"></div>

                            </a>

                        </div>

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="Daewoo Express Managed">

                                <div><img src="{{ asset('images/default/couriers/prefered-logo-21.svg') }}"
                                        width="100" alt="Daewoo Express Managed"></div>

                            </a>

                        </div>

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="Swyft Managed">
                                <div><img src="{{ asset('images/default/couriers/prefered-logo-11.svg') }}"
                                        width="100" alt="Swyft Managed"></div>

                            </a>

                        </div>

                        <div class="col-md-3 col-6 text-center p-2 d-flex justify-content-center align-items-center">

                            <a href="javascript: void(0);" class="avatar-icon-wrapper avatar-icon-lg m-0"
                                data-toggle="tooltip" title="FlyCourier Managed">
                                <div><img src="{{ asset('images/default/couriers/prefered-logo-13.svg') }}"
                                        width="100" alt="FlyCourier Managed"></div>

                            </a>

                        </div>

                    </div>

                </div>

                <div class="card-footer border-0">
                    <div class="row justify-content-center no-gutters">
                        <div class="col-lg-12 text-center py-3 d-flex justify-content-center align-items-center">
                            <a href="{{ route('admin.profile') }}" class="btn btn-primary">Start here by completing
                                your profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
