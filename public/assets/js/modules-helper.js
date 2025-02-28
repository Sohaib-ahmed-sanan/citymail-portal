let path = window.location.pathname;
var listRoute = path;
var is_responsive = false;
var ajaxBody;
switch (path) {
    case '/sales_persons':
        var columns = [{
                data: "SNO"
            },
            {
                data: "FIRSTNAME",
            },
            {
                data: "LASTNAME",
            },
            {
                data: "EMAIL",
            },
            {
                data: "PHONE",
            },
            {
                data: "STATUS",
            },
            {
                data: "ACTIONS",
            },
        ];
        break;
    case '/riders':
        var columns = [{
                data: "SNO",
            },
            {
                data: "FIRSTNAME",
            },
            {
                data: "LASTNAME",
            },
            {
                data: "EMAIL",
            },
            {
                data: "PHONE",
            },
            {
                data: "ADDRESS",
            },
            {
                data: "CITY",
            },
            {
                data: "STATUS",
            },
            {
                data: "ACTIONS",
            },
        ];
        break;
    case '/routes':
        var columns = [{
                data: "SNO",
            },
            {
                data: "CITY",
            },
            {
                data: "ADDRESS",
            },
            {
                data: "STATUS",
            },
            {
                data: "ACTIONS",
            },
        ];
        break;
    case '/pickup-location':
        var columns = [{
                data: "SNO",
            },
            {
                data: "PICKUPID",
            },
            {
                data: "ACCOUNT",
            },
            {
                data: "NAME",
            },
            {
                data: "EMAIL",
            },
            {
                data: "PHONE",
            },
            {
                data: "ADDRESS",
            },
            {
                data: "CITY",
            },
            {
                data: "ACCTYPE",
            },
            {
                data: "STATUS",
            },
            {
                data: "ACTIONS",
            },
        ];
        break;
    case '/stations':
        var columns = [{
                data: "SNO",
            },
            {
                data: "NAME",
            },
            {
                data: "ADDRESS",
            },
            {
                data: "CITY",
            },
            {
                data: "STATUS",
            },
            {
                data: "ACTIONS",
            },
        ];
        break;
    case '/couriers':
        var columns = [{
                data: "SNO"
            },
            {
                data: "COURIER"
            },
            {
                data: "ACCTITLE"
            },
            {
                data: "ACCNO"
            },
            {
                data: "USER"
            },
            {
                data: "ACTIONS"
            },
        ];
        break;
    case '/shipments':
        is_responsive = true
            var columns =  [{
                data: "SNO"
            },
            {
                data: "CN"
            },
            {
                data: "ACNO",
                visible: false
            },
            {
                data: "BUSINESSNAME",
                visible: false
            },
            {
                data: "NAME"
            },
            {
                data: "EMAIL",
                visible: false
            },
            {
                data: "PHONE",
                visible: false
            },
            {
                data: "SHIPREF"
            },
            {
                data: "DESTINATION",
                visible: false
            },
            {
                data: "DESCITY",
                visible: false
            },
            {
                data: "ADDRESS",
                visible: false
            },
            {
                data: "PARCELDET",
                visible: false
            },
            {
                data: "AMOUNT"
            },
            {
                data: "ORIGCODE",
                visible: false
            },
            {
                data: "CONVERTEDAMT",
                visible: false
            },
            {
                data: "CONVERTEDCODE",
                visible: false
            },
            {
                data: "PEICES",
                visible: false
            },
            {
                data: "WEIGHT"
            },
            {
                data: "BOOKEDAT"
            },
            {
                data: "LASTSTATUSDATE",
                visible: false
            },
            {
                data: "STATUS"
            },
            {
                data: "ACTIONS"
            }
        ];
        if (['1', '2', '3', '4', '5', '9'].includes(sessionType)) {
            columns.splice(4, 0, {
                data: "TPL",
                visible: false
            });
        }
    break;
    case '/assign-driver' :
        var columns = [
            { data: "SNO" },
            { data: "DATE" },
            { data: "PICKUP" },
            { data: "CITY" },
            { data: "CUSTOMER" },
            { data: "SHIPMENT" },
            { data: "ACCTYPE",visible: false },
            { data: "STATUS" },
            { data: "ACTION" }
        ];
    break;
    case '/pickups':
        var columns = [
            {data: "SNO"},
            {data: "SHEET"},
            {data: "DATE"},
            {data: "CNCOUNT"},
            {data: "ACTION"}
        ];
        ajaxBody = {
            arrival_type: '0',
            _token: $('meta[name="csrf-token"]').attr('content')
        }
    break;
    case '/international-tarrifs':
        var columns = [
            {
                data: "SNO"
            },{
                data: "Service"
            },
            {
                data: "COUNT"
            },
            {
                data: "ACTIONS"
            }
        ];
    break;
    default:
        break;
}
