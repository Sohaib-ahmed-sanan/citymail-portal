<?php 

$servername = "localhost";
$username = "mycitymailcom_citymail_stagging";
$password = "Mcb{n80sFSS*";
$dbname = "mycitymailcom_citymail_stagging";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully";

$query = "SELECT s.consignee_name,s.destination_city_id,s.thirdparty_consignment_no,s.weight_charged,s.peices_charged,s.sst_charges,s.gst_charges,s.bac_charges,s.handling_charges,
s.service_charges,s.total_charges,s.order_amount,pl.city_id As origin_city,cbc_invoice.invoice_no As invoice_no,delivery_status.name As status_name
            FROM  `shipments` As s
            LEFT JOIN `delivery_status` ON s.status = `delivery_status`.`id` 
            LEFT JOIN `pickup_locations` pl ON s.pickup_location_id = pl.id 
            LEFT JOIN `invoice_details` ON s.consignment_no = invoice_details.consignment_no 
            LEFT JOIN `cbc_invoice` ON invoice_details.invoice_id = cbc_invoice.id 
            WHERE s.company_id = '100004' AND s.is_deleted = 'N' AND s.created_at BETWEEN '2024-11-01 00:00:00' AND '2024-12-07 23:59:59'";
$result = $conn->query($query);
$arr = [];
foreach($result as $row)
{
    print_r($row);
}  
die;