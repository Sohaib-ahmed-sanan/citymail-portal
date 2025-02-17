 {{-- Tracking modal --}}
    <div class="modal fade show" id="tracking_modal" role="dialog" aria-labelledby="trackingModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-800" role="document">
            <div class="modal-content" id="trackingModaldetail">
                <div class="ticketcreatewrap orderview customerowstyle clearfix">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title-default">TRACK SHIPMENT</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body p-0" id="track-details">
                        {{-- <div class="main_detail ticketinfowrap clearfix">
                        </div>
                        <div class="ordertrackingdetail p-3">
                            <div class="popheading">
                                <h5 class="display-5 my-1 font-weight-bold">TRACKING DETAILS: <span class="cn_div"></span>
                                </h5>
                            </div>
                            <div class="track-details">
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 <div class="app-footer font-size-sm text-black-50 text-center align-items-center justify-content-center">
     <div class="text-center">
         <p> Copyright &copy; {{ \Carbon\Carbon::now()->format('Y') }} - Created By <a href="https://getorio.com"
                 title="ORIO" target="_blank" style="border-bottom: 1px solid; color: #2f2f7e !important;">ORIO</a>
         </p>
     </div>
 </div>
 </div>
 <script src="{{ asset('assets/js/core/jquery-3.3.1.min.js') }}"></script>
 {{-- Poper js --}}
 <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
 <script src="{{ asset('assets/js/core/jquery.validate.min.js') }}"></script>
 {{-- Bootstrap --}}
 <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/bootstrap/bootstrap.min.js') }}"></script>
 {{-- Parsely validation --}}
 <script src="{{ asset('assets/js/core/parsley.min.js') }}"></script>
 {{-- Metis menue --}}
 <script src="{{ asset('assets/vendor/metismenu/js/metismenu.min.js') }}"></script>
 {{-- Metis menue init --}}
 <script src="{{ asset('assets/js/demo/metismenu/metismenu.min.js') }}"></script>
 <!--==================================Perfect scrollbar init==================================-->
 <!--Perfect scrollbar-->
 <script src="{{ asset('assets/vendor/perfect-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
 <!--Perfect scrollbar init-->
 <script src="{{ asset('assets/js/demo/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
 <!--==================================FeatherIcons==================================-->
 <script src="{{ asset('assets/vendor/feather-icons/js/feather-icons.min.js') }}"></script>
 <!--==================================FeatherIcons init==================================-->
 <script src="{{ asset('assets/js/demo/feather-icons/feather-icons.min.js') }}"></script>
 <!--==================================Layout==================================-->
 <script src="{{ asset('assets/js/core/bamburgh.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/listjs/js/list.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/listjs/list.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/select2/select2.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/notify/js/notify.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/sweet-alerts/js/sweetalert.min.js') }}"></script>
 {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
 <script src="{{ asset('assets/js/core/jquery.cookie.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
 <script src="{{ asset('assets/js/core/moment.min.js') }}"></script>
 <script src="{{ asset('assets/js/core/daterangepicker.js') }}"></script>
 <!--==================================DataTable==================================-->
 <script src="{{ asset('assets/js/demo/datatablebuttons/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/dataTables.buttons.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/buttons.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/jszip.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/buttons.html5.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/dataTables.responsive.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/responsive.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/dataTables.scroller.min.js') }}"></script>
 <script src="{{ asset('assets/js/demo/datatablebuttons/buttons.colVis.min.js') }}"></script>
 <!--==================================DataTable==================================-->
 <script src="{{ asset('assets/vendor/dropzone/js/dropzone.min.js') }}"></script>
 {{-- appax charts --}}
 <script src="{{ asset('assets/vendor/apexcharts/js/apexcharts.min.js') }}"></script>
 <!--Common sctipts and functions-->
 <script src="{{ asset('assets/js/core/common.js') }}"></script>
 <!--Dropzone init-->
 <script src="{{ asset('assets/js/demo/dropzone/init_dropzone.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
 <script>
     @if (session('error'))
         swal.fire({
             icon: "error",
             title: "Incomplete Profile",
             text: " {{ session('error') }}",
             confirmButtonClass: "btn-success",
             type: "error",
             showCancelButton: true,
             confirmButtonText: 'My account',
             cancelButtonText: 'cancel'
         }).then(t => {
             t.value && window.open("{{ route('admin.profile') }}");
         });
     @endif
     var track_route = "{{ Route('admin.tracking_data') }}";
 </script>
 <script src="{{ asset('assets/js/modules-helper.js') }}"></script>
 @yield('scripts')
