let path = window.location.pathname;
var listRoute = path;
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
    default:
        break;
}
