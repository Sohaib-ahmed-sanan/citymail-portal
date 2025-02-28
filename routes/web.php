<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\authController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\printController;
use App\Http\Controllers\commonController;
use App\Http\Controllers\arrivalController;
use App\Http\Controllers\bookingController;
use App\Http\Controllers\invoiceController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\reportsController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\operationsController;
use App\Http\Controllers\thirdPartyController;
use App\Http\Controllers\ArrivalDestinationController;
use App\Http\Controllers\expressShipmentsController;
use App\Http\Controllers\internationalTarrifController;

// register/login route
Route::middleware('guest_check')
    ->controller(authController::class)
    ->group(function () {
        //--- Views routes
        Route::get('/login', 'login')->name('auth.login');
        Route::get('/signup', 'register')->name('auth.register');
        Route::get('account-activation', 'acc_activation')->name('admin.acc_activation');
        Route::get('forgot-pass', 'forgot_pass')->name('admin.forgot-pass');
        Route::match(['get', 'post'], 'reset-password', 'reset_password')->name('admin.reset-password');
        // account creation ajax route
        Route::post('store-registration', 'store_registration')->name('admin.store_registration');
        // login check ajax route
        Route::post('login-check', 'login_check')->name('auth.login_check');
        // forgot-pass check ajax route
        Route::post('check-forgot-pass', 'check_forgot_pass')->name('admin.check-forgot-pass');
        // Route::post('reset-password','reset_password')->name("admin.reset-password");
        // activaton check ajax route
        Route::post('check-activaton', 'check_activaton')->name('admin.check_activaton');
    });

Route::middleware('LoginCheck')->group(function () {
    // change pass view route
    Route::get('/change-pass', [authController::class, 'change_pass'])->name('admin.changePass');
    // change pass ajax route
    Route::post('/update-pass', [authController::class, 'update_pass'])->name('admin.updatePass');
    // profile routes
    Route::controller(profileController::class)->group(function () {
        // dashboard view route
        Route::match(['get', 'post'], '/', 'index')->name('admin.index');
        // admin profile page view route
        Route::get('/profile', 'profile')->name('admin.profile');
        Route::get('/developer-center', 'developer_center')->name('admin.developer-center');
        // customer profile page view route
        Route::match(['get', 'post'], '/customer-profile', 'customer_profile')->name('admin.customerProfile');
        // update profile ajax route
        Route::post('/update-profile', 'update_profile')->name('admin.updateProfile');
        // update profile images ajax route
        Route::post('/uploadProfileImages', 'uploadProfile_images')->name('admin.uploadProfileData');
        // company profile
        Route::match(['get', 'post'], '/company-settings', 'company_settings')
            ->name('admin.company_settings')
            ->middleware('company_check');
        //  logout
        Route::get('/logout', 'logout')->name('admin.logout');
    });
    // -------------------------------------- xxxxxxx --------------------------------------
    // admin routes
    Route::controller(adminController::class)->group(function () {
        Route::match(['get', 'post'], '/sales_persons', 'sales_person')
            ->name('admin.salesPerson')
            ->middleware('company_check');
        Route::match(['get', 'post'], 'add_edit_salePerson/{id?}', 'add_edit_salesPerson')
            ->name('admin.add_edit_salePerson')
            ->middleware('company_check');
        //------ RIDERS
        Route::match(['get', 'post'], '/riders', 'riders')
            ->name('admin.riders')
            ->middleware('company_check');
        // for add add edit purpose
        Route::match(['get', 'post'], 'add_edit_rider/{id?}', 'add_edit_rider')
            ->name('admin.add_edit_rider')
            ->middleware('company_check');
        // ---- Routes  modules
        Route::match(['get', 'post'], '/routes', 'routes')
            ->name('admin.routes')
            ->middleware('company_check');
        // for add add edit purpose
        Route::match(['get', 'post'], 'add_edit_route/{id?}', 'add_edit_route')
            ->name('admin.add_edit_route')
            ->middleware('company_check');
        // --- PICKUP LOCATIONS
        Route::match(['get', 'post'], '/pickup-location', 'pickup_locations')->name('admin.pickupLocation');
        // for add add edit purpose
        Route::match(['get', 'post'], 'add_edit_location/{id?}', 'add_edit_locations')->name('admin.add_edit_pickupLocation');
        // --- STATIONS
        Route::match(['get', 'post'], '/stations', 'stations')
            ->name('admin.stations')
            ->middleware('company_check');
        // for add add edit purpose
        Route::match(['get', 'post'], 'add_edit_station/{id?}', 'add_edit_station')
            ->name('admin.add_edit_station')
            ->middleware('company_check');
        // for add add edit purpose
        Route::match(['get', 'post'], '/cities-collections', 'cities_collection')->name('admin.cities_collection');
        Route::match(['get', 'post'], 'add_edit_collection/{id?}', 'add_edit_collection')->name('admin.add_edit_collection');
        // courier cities mapping
        Route::match(['get', 'post'], "/city-mapping", "city_mapping")->name("admin.cityMapping");
        Route::match(['get', 'post'], 'add_edit_city_mapping/{id?}', "add_edit_city_mapping")->name("admin.add_edit_cityMapping");      

    });
    // customers route
    Route::controller(customerController::class)->group(function () {
        Route::middleware('company_check')->group(function () {
            Route::match(['get', 'post'], '/customers', 'customers')->name('admin.customers');
            // for add add edit view and db purpose
            Route::match(['get', 'post'], 'add-edit-customer/{id?}', 'add_edit_customer')->name('customer.add_edit_customer');
            // for inserting charges/tarifs
            Route::post('/insert-charges', 'insert_charges');
            // for updating charges/tarifs
            Route::post('/update-charges', 'update_tariff');
            // --- CUSTOMER SUB ACCOUNTS
            Route::match(['get', 'post'], '/customer-sub-accounts', 'sub_accounts')->name('customer.sub_accounts');
        });
        // for add add edit purpose
        Route::match(['get', 'post'], 'add-edit-sub-account/{id?}', 'add_edit_sub_account')->name('customer.add_edit_sub_account');
        // --- CUSTOMER SUB USERS
        Route::match(['get', 'post'], '/customer-sub-users', 'sub_users')->name('customer.sub_users');
        // for add add edit purpose
        Route::match(['get', 'post'], 'add-edit-sub-users/{id?}', 'add_edit_sub_users')->name('customer.add_edit_sub_user');
    });
    // booking routes
    Route::controller(bookingController::class)->group(function () {
        //  manual-booking view route
        Route::match(['get', 'post'], '/shipments', 'shipments')->name('admin.manualBooking');
        // for add add edit purpose
        Route::match(['get', 'post'], 'add_edit_booking/{id?}', 'add_edit_bookings')->name('admin.add_edit_bookings');
        // bulk booking
        Route::get('/bulk-booking', 'bulk_booking')->name('admin.bulk_booking');
        Route::post('/upload-bulk-file', 'upload_bulk_file')->name('admin.upload_bulk_file');
        Route::post('/push-orders', 'push_orders')->name('admin.push-orders');
        // consignment void
        Route::post('/cancle-consignment', 'cancle_cn')->name('admin.cancle_cn');
    });
    //  arival (origin / pickup) route
    Route::middleware('company_check')->group(function () {
        Route::controller(arrivalController::class)->group(function () {
            Route::match(['get', 'post'], '/pickups', 'arrivals')->name('admin.arivals');
            Route::match(['get', 'post'], 'add-edit-pickups/{id?}', 'add_edit_arrivals')->name('admin.add_edit_arrivals');
            // for fetching the arrivals ajaxes
            Route::post('/fetch-pickup-cn', 'fetch_arival_cn')->name('admin.fetch_arival_cn');
            Route::post('/fetch-pickups', 'fetch_arival')->name('admin.fetch_arival');
            Route::post('/insert-pickups', 'insert_arival')->name('admin.insert_arival');
        });

        Route::controller(ArrivalDestinationController::class)->group(function () {
            Route::match(['get', 'post'], '/arrivals', 'arrivals')->name('admin.arrival-destination');
            Route::match(['get', 'post'], 'add-edit-arrival/{id?}', 'add_edit_arrivals')->name('admin.add_edit_arrival-des');
            // for fetching the arrivals ajaxes
            Route::post('/fetch-arrival-cn', 'fetch_arival_cn');
            Route::post('/fetch-arrivals', 'fetch_arival');
            Route::post('/insert-arrival', 'insert_arival');
            Route::post('/import-bulk-arrival', 'insert_arival');
        });
    });
    Route::controller(operationsController::class)->group(function () {
        Route::middleware('company_check')->group(function () {
            Route::match(['get', 'post'], '/assign-driver', 'assign_driver')->name('admin.pickups');
            Route::post('/list-assign-driver', 'list_pickups')->name('admin.list_pickups');
            Route::post('/generate-assign-driver', 'generate_assign_driver')->name('admin.generate_pickup');
            // manifist route
            Route::match(['get', 'post'], '/manifists', 'manifists')->name('admin.manifist');
            // for add add edit purpose
            Route::match(['get', 'post'], 'add_edit_manifist/{id?}', 'add_edit_manifist')->name('admin.add_edit_manifist');
            // for fetching data through ajax
            Route::post('/fetch-manifist-data', 'fetch_manifist_data')->name('admin.fetch_data');
            // de-manifist
            Route::match(['get', 'post'], '/de-manifists', 'de_manifists')->name('admin.de-manifist');
            // for add add edit purpose
            Route::match(['get', 'post'], 'add_de_manifist/{id?}', 'add_edit_de_manifist')->name('admin.add_edit_de_manifist');
            // for fetching data
            Route::post('/fetch-demanifist-data', 'fetch_demanifest_data')->name('admin.de-fetch_data');
            // delivery sheet route
            Route::match(['get', 'post'], '/delivery-sheet', 'delivery_sheet')->name('admin.delivery_sheet');
            // for add edit purpose
            Route::match(['get', 'post'], 'add-edit-delivery-sheet/{id?}', 'add_edit_deliverySheet')->name('admin.add_edit_deliverySheet');
            Route::post('/fetch-delivery-data', 'fetch_delivery_data')->name('admin.delivery_data');
            // couriers
            Route::match(['get', 'post'], '/couriers', 'couriers')->name('admin.couriers');
            Route::match(['get', 'post'], 'add_edit_couriers/{id?}', 'add_edit_couriers')->name('admin.add_edit_couriers');
            Route::post('add-edit-courier-code/{id?}', 'add_edit_courier_code')->name('admin.add_edit_courier_code');
        });
        // tracking
        Route::get('/tracking', 'tracking')->name('admin.tracking');
        Route::post('/get-tracking-data', 'get_tracking_data')->name('admin.tracking_data');
        // loadsheets
        Route::match(['get', 'post'], '/loadsheets', 'loadsheets')->name('admin.loadSheeet');
        Route::post('/generate-loadsheet', 'create_loadsheet')->name('admin.generate_loadsheet');
        // ops subuser
        // list sub users
        Route::match(['get', 'post'], 'list-subusers', 'sub_users')->name('ops.sub-users');
        Route::match(['get', 'post'], 'add-edit-subuser/{id?}', 'add_edit_sub_user')->name('ops.add-edit-sub-users');
        // shipper advice
        Route::match(['get', 'post'], '/shipper-advice', 'shipper_advice')->name('admin.shipper_advice');
        Route::post('/chats-shipper-advice', 'chats_shipper_advice')->name('admin.chats_shipper_advice');
        Route::post('/store-shipper-advice', 'store_shipper_advice')->name('admin.store_shipper_advice');
        Route::match(['get', 'post'], 'city-list', 'city_list')->name("admin.city-list");
    });
    Route::controller(expressShipmentsController::class)->group(function () {
            Route::match(['get', 'post'], 'express-shipments', 'express_shipments')->name('admin.express-shipments');
            Route::match(['get', 'post'], 'add-edit-express-shipment/{id?}', 'add_edit_express_shipments')->name('admin.add_edit-express-shipments');
            Route::post('store-express-shipment/{id?}', 'store_express_shipments')->name('admin.store-express-shipments');
            Route::post('get-existing-shipper', 'get_existing_shipper')->name('admin.get-existing-shipper');
            Route::post('add-walkin-customer', 'add_walkin_customer')->name('admin.add-walkin-customer');
            Route::post('get-walkin-customer', 'get_walkin_customer')->name('admin.get-walkin-customer');
    });
    Route::controller(internationalTarrifController::class)->group(function () {
            Route::match(['get', 'post'], 'international-tarrifs', 'international_tarrifs')->name('admin.international-tarrifs');
            Route::match(['get', 'post'], 'view-international-tarrif/{id?}', 'view_international_tarrif')->name('admin.view-international-tarrif');
            Route::post('add-international-charges', 'add_international_charges')->name('admin.add-international-charges');
            Route::post('update-international-charges', 'update_international_charges')->name('admin.update-international-charges');
    });
    
    // invoice controller
    Route::controller(invoiceController::class)->group(function () {
        Route::match(['get', 'post'], '/cbc-invoice', 'invoice')->name('ops.invoice');
        Route::get('/add-invoice', 'add_invoice')->name('ops.add_invoice');
        Route::post('/fetch-invoice-data', 'fetch_invoice_data')->name('admin.fetch_invoice_data');
        Route::post('/store-invoice-data', 'store_invoice_data')->name('admin.store_invoice_data');
        // cashier / tpl manual
        Route::match(['get', 'post'], '/thirdparty-payments', 'third_party_payments')->name('ops.tpl_payments');
        Route::post('add-thirdparty-payments', 'add_third_party_payments')->name('ops.add_third_party_payments');
        Route::post('import-tpl-payments', 'import_tpl_payments')->name('ops.import_tpl_payments');
        // charges adjustments
        Route::match(['get', 'post'], '/charges-adjustments', 'charges_adjustments')->name('ops.charges-adjustments');
        //delete invoice
        Route::post('/delete-invoice', 'delete_invoice')->name('ops.delete_invoice');
        Route::post('/update-invoice', 'update_invoice')->name('ops.update_invoice');
    });
    // manual third party
    Route::middleware('company_check')->group(function () {
        Route::controller(thirdPartyController::class)->group(function () {
            // rules
            Route::get('/rules', 'rules')->name('admin.rules');
            Route::post('/get-selected-service', 'get_selected_service')->name('admin.get_selected_service');
            Route::post('/add-rule', 'add_rule')->name('admin.add_rule');
            Route::post('/update-rule', 'update_rule')->name('admin.update_rule');
            // third party auto manual
            Route::get('/tpl-manual', 'tpl_manual')->name('admin.tpl_manual');
            Route::post('/list-tpl-manual', 'list_tpl_manual')->name('admin.list_tpl_manual');
            Route::post('/get-tpl-selected', 'get_tpl_selected')->name('admin.get_tpl_selected');
            Route::post('/add-manual-tpl', 'add_manual_tpl')->name('admin.add_manual_tpl');
            Route::post('/tpl-cn-void', 'cn_void')->name('admin.tpl_cn_void');
            Route::get('/tpl-cn-print/{courier_id}/{account_id}/{cn_number}', 'cn_print')->name('admin.tpl_cn_print');
            Route::post('/tpl-cn-print-bulk', 'cn_print_bulk')->name('admin.tpl_cn_print_bulk');
            Route::post('/tpl-cn-track', 'cn_track')->name('admin.tpl_cn_track');
        });
    });
    // all pdfs
    Route::controller(printController::class)->group(function () {
        Route::get('/invoice-pdf/{id}', 'invoice')->name('admin.invoice_pdf');
        Route::get('/loadsheet-pdf/{id}', 'loadsheet')->name('admin.loadsheet-pdf');
        Route::get('/pickup-sheet-pdf/{id}', 'pickup')->name('admin.pickup-sheet-pdf')->middleware('company_check');
        Route::get('/arrival-sheet-pdf/{id}', 'arrival')->name('admin.arrivalsheet-pdf')->middleware('company_check');
        Route::get('/manifist-sheet-pdf/{id}', 'manifist')->name('admin.manifistsheet-pdf')->middleware('company_check');
        Route::get('/de-manifist-sheet-pdf/{id}', 'de_manifist')->name('admin.de-manifistsheet-pdf')->middleware('company_check');
        Route::get('/delivery-sheet-pdf/{id}', 'delivery_sheet')->name('admin.dileverySheetPDF')->middleware('company_check');
        Route::get('/proforma-invoice-pdf/{id}', 'proforma_invoice')->name('admin.proforma-invoice');
    });
    // all reports
    Route::controller(reportsController::class)->group(function () {
        //customer services
        Route::match(['get', 'post'], '/customer-reports', 'customer_reports')->name('admin.customer_reports');
        Route::match(['get', 'post'], '/monthly-invoice-reports', 'monthly_invoice_reports')->name('admin.monthly_invoice');
        Route::match(['get', 'post'], '/revenue-details', 'revenue_details')->name('admin.revenue_details');
        Route::match(['get', 'post'], '/outstanding-details', 'outstanding_details')->name('admin.outstanding_details');
        Route::middleware('company_check')->group(function () {
            Route::match(['get', 'post'], '/sales-person-reports', 'sales_person_reports')->name('ops.sales_person_report');
            Route::match(['get', 'post'], '/sales-reports', 'sales_reports')->name('ops.sales_report');
        });
    });
    // ------------------------------------- xxxxxxxx -----------------------------------------------
    // common routes for status update delete and some other operations
    Route::controller(commonController::class)->group(function () {
        Route::post('/delete', 'delete')->name('admin.delete');
        Route::post('/status', 'update_status')->name('admin.updateStatus');
        Route::post('/get-customers-all', 'get_customers')->name('admin.getCustomers');
        // common AJAX routes for operations and portal
        Route::post('/get-courier-acc', 'get_courier_acc')->name('admin.common_courier_acc');
        Route::post('/get-courier-services', 'get_courier_services')->name('admin.common_courier_services');
        Route::post('/get-courier-code', 'get_courier_code')->name('admin.get-courier-code');
        Route::post('/pickup-location-specific', 'pickuplocation_specific')->name('admin.getPickuplocation');
        // Route::post("/get-countries-all", "get_countries")->name("get_countries");
        Route::post('/get-cities-specific', 'get_cities')->name('get_cities');
        Route::post('/get-sub-accounts', 'get_sub_accounts')->name('admin.get-sub-accounts');
        Route::post('/get-customer-service', 'get_customer_service')->name('admin.get-customer-service');
        // to get the riders in dropdown
        Route::post('/drop-riders', 'get_riders_all')->name('admin.drop_riders');
        // route to cleare all the cache
        Route::post('/clear-cache', 'cleare_cache')->name('admin.cleare_cache');
        Route::post('/ajax_testing', 'ajax_testing')->name('ajax_testing');
        Route::post('/get-stations', 'get_stations');
        Route::post("/get-courier-city", "get_courier_city")->name("admin.get-courier-city");
        Route::post("/add-city", "add_city")->name("admin.add_city");
    });
});

Route::get('/track', [commonController::class, 'web_view_track']);
Route::post('/get-tracking-data-web', [operationsController::class, 'get_tracking_data'])->name('admin.tracking_data_web');

Route::get('/airway-pdf/{id}', [printController::class,'airway_bill'])->name('admin.cn_print');

Route::get('get-ip', function (Request $request) {
    return $request->ip();
});
Route::get('test', function (Request $request) {
    return view('test');
});