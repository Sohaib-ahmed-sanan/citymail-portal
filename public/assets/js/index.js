//========================= Dashboard Init =========================
let Dashboard = function () {
    let DashboardReport = function () {
        if ($('#datepicker').length == 0) {
            return;
        }
        var picker = $('#datepicker');
        var start = moment().subtract(3, 'days');
        var end = moment();

        function cb(start, end, label) {
            var title = '';
            var range = '';
            var rangejson = '';
            if (label == 'Today') {
                title = 'Today:';
                range = start.format('MMM DD, YYYY');
                rangejson = start.format('YYYY-MM-DD');
            } else if (label == 'Yesterday') {
                title = 'Yesterday:';
                range = start.format('MMM DD, YYYY');
                rangejson = start.format('YYYY-MM-DD');
            } else {
                range = start.format('MMM DD, YYYY') + ' - ' + end.format('MMM DD, YYYY');
                rangejson = start.format('YYYY-MM-DD') + ' | ' + end.format('YYYY-MM-DD');
            }
            var selectrange = rangejson.split("|");
            if (selectrange.length != 2) {
                selectrange[1] = selectrange[0];
            }
            start_date = selectrange[0];
            end_date = selectrange[1];
            $("#total_orders,#total_customer").html('0');
            $(".total_outstandings,#total_order_amount").html('AED 0');
            $("#sparklines-outstanding-graph-1,#sparklines-outstanding-graph-2,#sparklines-order-graph,#sparklines-revenue-graph,#sparklines-customer-graph").html("");
            let data = {
                start_date: start_date,
                end_date: end_date,
                requestType: 'DashboardReport'
            };
            $.post('/', data, function (response) {
                if (response) {
                    let row = response;
                    let total_shipments = parseInt(row.order_counts);
                    $(".total_outstandings").html(`AED ${parseFloat(row.total_outstanding).toFixed(3)}`);
                    $("#total_shipments").html(total_shipments);
                    $("#total_revenue").html(`AED ${parseFloat(row.total_revenue).toFixed(3)}`);
                    $("#total_customer").html(row.accounts);
                    renderSparklinesGraph('sparklines-outstanding', '#0074fc', row.total_outstanding_arr);
                    renderSparklinesGraph('sparklines-shipments-count', '#0074fc', (row.order_counts_arr));
                    renderSparklinesGraph('sparklines-revenue', '#0074fc', (row.total_revenue_arr));
                    renderSparklinesGraph('sparklines-customers', '#0074fc', (row.account_count));
                   

                    let status_donut_array = row.status_arr;

                    const location_colors = ["#FF4560", "#00E396", "#775DD0", "#FEB019"];
                    const shipment_status_colors = ["#3290ff", "#ea7317",'#FFD767',"#b9d3b6", "#fec601", "#ff7400", "#74c497", "#e86199", "#F7414E"];
                    let location_labels = ["Saudi Arabia", "United Arab Emirates", "United States", "Bahrain", "Others"];

                    let required_status_donut = [1,19,21,9,6,24,14,16,2];

                    let filtered_donut_status = status_donut_array.filter(status => required_status_donut.includes(parseInt(status.status_id)));
                    filtered_donut_status.sort((a, b) => required_status_donut.indexOf(a.status_id) - required_status_donut.indexOf(b.status_id));
                    
                    var shipment_status_graph = filtered_donut_status.map(item => parseInt(item.shipment_count));
                    
                    var shipment_labels = filtered_donut_status.map(item => item.status_name);
                    
                    renderDonutGraph2("location_order_donut", location_labels,row.coutries_graph,location_colors);
                    renderDonutGraph2("shipments-status-donut", shipment_labels,shipment_status_graph,shipment_status_colors);

                  
                    var text_class = '',
                        bar_class = '';

                    row.status_arr.forEach(function (item) {
                        var status_id = String(item.status_id);
                        switch (status_id) {
                            case '1':
                                text_class = ".text-booked";
                                bar_class = ".booked-progress-bar";
                                break;
                            case '6':
                                text_class = ".text-on-hold";
                                bar_class = ".on-hold-progress-bar";
                                break;
                            case '2':
                                text_class = ".text-cancelled";
                                bar_class = ".cancelled-progress-bar";
                                break;
                            case '4':
                                text_class = ".text-arival";
                                bar_class = ".arival-progress-bar";
                                break;
                            case '16':
                                text_class = ".text-return-to-shipper";
                                bar_class = ".return-to-shipper-progress-bar";
                                break;
                            case '14':
                                text_class = ".text-delivered";
                                bar_class = ".delivered-progress-bar";
                                break;
                            case '21':
                                text_class = ".text-pickup";
                                bar_class = ".pickup-progress-bar";
                                break;
                            case '13':
                                text_class = ".text-on-route";
                                bar_class = ".on-route-progress-bar";
                                break;
                            case '9':
                                text_class = ".text-in-transit";
                                bar_class = ".in-transit-progress-bar";
                                break;
                            default:
                                break;
                        }
                        $(text_class).html(item.shipment_count);
                        let shipment_percentage =  ((parseInt(item.shipment_count) / total_shipments) * 100).toFixed(2);                        
                        $(bar_class).attr('aria-valuenow', (item.shipment_count <= 0 ? null : item.shipment_count)).css('width', (shipment_percentage <= 0 ? '0%' : `${shipment_percentage}%`));
                    });

                    $('#top_customers').html('');
                    row.customer_details.forEach(function (data) {
                        var html = `
                        <tr>
                            <td>
                                ${data.business_name}
                            </td>
                            <td>
                                ${data.phone}
                            </td>
                            <td>
                                ${data.email}
                            </td>
                            <td>
                                ${data.total_charges}
                            </td>
                            <td>
                                ${data.total_shipments}
                            </td>
                        </tr>
                        `;
                        $('#top_customers').append(html);
                    });

                    if (row.tpl_details.length > 0) {
                        $('#thirparty-status').html('');
                        var tpl_shipments = row.tpl_details.map(item => item.total_shipments);
                        if (tpl_shipments.some(count => count > 0)) { 
                            $('#tpl-section').removeClass('d-none')
                            row.tpl_details.forEach(function (tpl) {
                                if (tpl.total_shipments > 0) {
                                    var tpl_html = `<div class="col-xl-4 col-md-6 col-sm-12 mt-3">
                                            <div class="card card-box h-100">
                                                <div class="3pl-status-box px-2 py-4" style="position: relative;">
                                                    <div class="company-info-wrapper text-center mb-3">
                                                        <div class="company-logo">
                                                            <img src="${window.location.origin}/images/default/couriers/${tpl.courier_name}.svg"
                                                                alt="${tpl.courier_name}" width="60">
                                                        </div>
                                                        <h5 class="mt-2 fs-17 heading-text ">${tpl.account_title}</h5>
                                                    </div>
                                                    <div id="tpl_courier_${tpl.customer_courier_id}"></div>
                                                    <div class="row justify-content-center mt-2">
                                                        <div class="row justify-content-center col-md-11 mb-2">
                                                            <div class="col-md-8 pr-0">
                                                                <h5 class="mb-0 fs-16 heading-text ">Total Shipments</h5>
                                                            </div>
                                                            <div class="col-md-4 pl-0">
                                                                <p class="mb-0 fs-16 heading-text  text-right" id="tpl_courier_${tpl.customer_courier_id}_total_shipment">
                                                                    ${tpl.total_shipments}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row justify-content-center col-md-11 d-none">
                                                            <div class="col-md-6">
                                                                <h5 class="mb-0 fs-16 heading-text ">Total Amount</h5>
                                                            </div>
                                                            <div class="col-md-4 pl-0">
                                                                <p class="mb-0 fs-16 heading-text  text-right" id="tpl_courier_${tpl.customer_courier_id}_total_amount">
                                                                    15,230</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                                    $('#thirparty-status').append(tpl_html);
                                    var graph_id = 'tpl_courier_' + tpl.customer_courier_id;

                                    let required_tpl_donut = [1,2,4,24,14,16];

                                    let filtered_donut_status = tpl.detail.filter(status => required_tpl_donut.includes(parseInt(status.status_id)));
                                    
                                    filtered_donut_status.sort((a, b) => required_tpl_donut.indexOf(a.status_id) - required_tpl_donut.indexOf(b.status_id));
                                    
                                    filtered_donut_status = filtered_donut_status.map(item => 
                                        item.status_name == "Arrived At Destination" ? { ...item, status_name: "Arrived at Dest" }  : item
                                    );
                                                                         
                                    let tplColor = ['#3290FF', '#F7414E', '#ea7317', '#ff7400', '#74c497', '#e86199'];
                                    renderThirdPartyGraph(graph_id,filtered_donut_status,tplColor);
                                }
                            });
                        } else {
                            $('#tpl-section').addClass('d-none')
                        }
                       
                    }
                }
                init_tooltip();
            });
            picker.find('span.date_range').html(range);
            picker.find('span.date_title').html(title);
        }
        picker.daterangepicker({
            startDate: start,
            endDate: end,
            opens: 'left',
            minDate: moment().subtract(4, 'months'),
            maxDate: moment(),
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            },
            locale: {
                monthNames: moment.months()
            },
        }, cb);
        cb(start, end, '');
    };
    return {
        init: function () {
            DashboardReport();
        }
    };
}();
//========================= Dashboard Init =========================
$(document).ready(function () {
    Dashboard.init();
});
//========================= Dashboard Init =========================
