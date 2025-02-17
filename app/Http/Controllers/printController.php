<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Elibyy\TCPDF\Facades\TCPDF;

class printController extends Controller
{
    protected function city_name($city_id)
    {
        $cities = get_all_cities();
        $filtered_city = array_filter($cities, function ($city) use ($city_id) {
            return $city->id == $city_id;
        });
        $filtered_city = reset($filtered_city);
        return $filtered_city->city;
    }
    protected function tc_init($title)
    {
        get_all_status();
        $pdf = new TCPDF('P');
        // $pdf::SetCreator(PDF_CREATOR);
        $pdf::SetTitle($title);
        $pdf::setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf::setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf::SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf::SetMargins(8, 15, 6);
        // $pdf::SetMargins(8, 15, 6);
        $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf::SetPrintHeader(false);
        $pdf::SetFillColor(255, 255, 255);
        $pdf::ln(-5);
        $pdf::SetFont('helvetica', 'B', 8);
        $style = array(
            'position' => 'center',
            'align' => 'C',
            'stretch' => false,
            'cellfitalign' => '',
            'border' => 'auto',
            'hpadding' => '5px',
            'vpadding' => '10px',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false,
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 3
        );
        $pdf::AddPage();
        $pdf::ln(12);
        return $pdf;
    }
    protected function output($pdf)
    {
        // ob_end_clean();
        return $pdf::Output();
    }
    public function invoice($id, Request $request)
    {
        get_all_status();
        $company_id = session('company_id');
        $invoice_id = $id;
        $data = compact('company_id', 'invoice_id');
        $result = getAPIdata('invoice/single', $data);
        $weight_charged = $peices_charged = $total_cod = $total_charges = 0;
        if ($result->status == 1) {
            $single_details = $result->payload[0];
            $pdf = $this->tc_init('Customer Invoice');
            $pdf::ln();
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'CUSTOMER INVOICE', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln();
            // $pdf::Cell(193, 5, '_________________________________________', 10, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'INVOICE FROM:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $single_details->invoice_from_date, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(48.5, 5, 'INVOICE TO:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $single_details->invoice_to_date, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(48.5, 5, 'CUSTOMER NAME:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $single_details->customer_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'INVOICE DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $single_details->invoice_creation_date, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'INVOICE NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $invoice_id, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details of Shipments', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(27, 5, 'Consignee Name', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(20.5, 5, 'Booking Date', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(14.5, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(12.5, 5, 'Peices', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(23.5, 5, 'Status', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(23.5, 5, 'Service Charges', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(18.5, 5, 'COD', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(18, 5, 'Total', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', '', 8);
            foreach ($result->payload as $key => $row) {
                // for summing up the values
                $weight_charged += (int) $row->weight_charged;
                $peices_charged += (int) $row->peices_charged;
                if($row->status == '16')
                {
                    $cod = 0;
                    $charges = $row->rto_gst_charges+$row->sst_charges+$row->bac_charges+$row->handling_charges+$row->rto_charges;
                }else{
                    $cod = $row->order_amount;
                    $charges = $row->gst_charges+$row->sst_charges+$row->bac_charges+$row->handling_charges+$row->service_charges;
                }
                
                $total_cod += $cod;
                
                $total = ($cod - $charges);
                
                $total_charges += $charges;


                //---------------------------------------
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, "$row->consignment_no", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(27, 5, $row->consignee_name, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(20.5, 5, Carbon::parse($row->booked_date)->format('d-m-Y'), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(14.5, 5, $row->weight_charged, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(12.5, 5, $row->peices_charged, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(23.5, 5, ($row->status == '16' ? 'Returned' : session('status')[$row->status - 1]->name), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(23.5, 5, $charges, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(18.5, 5, ($row->status == '16' ? '0' : $row->order_amount), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(18, 5, $total, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
                
            }
            $pdf::setCellPadding(1);
            $pdf::ln(5);
            $pdf::setCellPadding(1);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(131.6, 5, 'GRAND TOTAL', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(23.5, 5,$total_charges, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            
            $pdf::Cell(18.5, 5,$total_cod, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(18, 5, $total_cod-$total_charges, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED INVOICE & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);
        } else {
            return redirect()->back();
        }
    }
    public function loadsheet($id, Request $request)
    {

        $cities = get_all_cities();

        $customer_acno = session('acno');
        $sheet_no = $id;
        $data = compact('customer_acno', 'sheet_no');
        $result = getAPIdata('loadSheets/single', $data);
        if ($result->status == 1) {
            $loadsheet_created = array_column($result->payload,'loadsheet_created_at');
            $loadsheet_created = $loadsheet_created[0];
            
            $pdf = $this->tc_init('Loadsheet');
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'LOAD SHEET', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln();
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'ACCOUNT NAME:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '' . $result->payload[0]->business_name . ' (' . $result->payload[0]->acno . ')', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SHEET NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $sheet_no, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, Carbon::parse($loadsheet_created)->format('Y-m-d'), 0, 0, 'L', 1, '', 0, false, 'T', 'C');

            // tabel header
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details of Shipment', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(20.5, 5, 'Booking Date', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Consignee Name', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Consignee Phone', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(15.5, 5, 'Origin', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(18.5, 5, 'Destination', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'Reference', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(10.5, 5, 'Peice', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(11.5, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            foreach ($result->payload as $key => $row) {
                //--------------------------------------
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, "$row->consignment_no", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(20.5, 5, Carbon::parse($row->booked_at)->format('Y-m-d'), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $row->consignee_name, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $row->consignee_phone, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(15.5, 5, $this->city_name($row->origin_city), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(18.5, 5, $this->city_name($row->destination_city_id), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, $row->shipment_referance, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(10.5, 5, $row->peices, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(11.5, 5, $row->weight, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);

            }

            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED LOAD SHEET & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);
        } else {
            return redirect()->back();
        }
    }
    public function pickup($id, Request $request)
    {
        $company_id = session('company_id');
        $arrival_no = $id;
        $data = compact('company_id', 'arrival_no');
        $result = getAPIdata('arrival-origin/single', $data);
        $arrivals = $result->payload;
        // dd($arrivals);
        if (count($arrivals) > 0) {
            $pdf = $this->tc_init('PickupSheet #' . $arrivals[0]->arrival_no);
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'PICKUP SHEET', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln();
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SHEET NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $arrivals[0]->arrival_no, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'STATION:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $arrivals[0]->station_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, date('Y-m-d'), 0, 0, 'L', 1, '', 0, false, 'T', 'C');

            // tabel header
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details Of Pickup', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(51.9, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(50.5, 5, 'Pickup Date', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(40.5, 5, 'Peice', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(40.5, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            foreach ($result->payload as $key => $row) {
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(51.9, 5, "$row->cn_numbers", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(50.5, 5, Carbon::parse($row->created_at)->format('Y-m-d'), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(40.5, 5, $row->peices, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(40.5, 5, $row->weight, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
            }

            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED PICKUP SHEET & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);

        } else {
            return redirect()->back();
        }

    }
    public function arrival($id, Request $request)
    {
        $company_id = session('company_id');
        $arrival_no = $id;
        $data = compact('company_id', 'arrival_no');
        $result = getAPIdata('arrival-destination/single', $data);
        $arrivals = $result->payload;
        // dd($arrivals);
        if (count($arrivals) > 0) {
            $pdf = $this->tc_init('ArrivalSheet #' . $arrivals[0]->arrival_no);
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'ARRIVAL SHEET', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln();
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SHEET NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $arrivals[0]->arrival_no, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'STATION:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $arrivals[0]->station_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, date('Y-m-d'), 0, 0, 'L', 1, '', 0, false, 'T', 'C');

            // tabel header
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details of Arival', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(51.9, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(50.5, 5, 'Arival Date', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(40.5, 5, 'Peice', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(40.5, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            foreach ($result->payload as $key => $row) {
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(51.9, 5, "$row->cn_numbers", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(50.5, 5, Carbon::parse($row->created_at)->format('Y-m-d'), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(40.5, 5, $row->peices, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(40.5, 5, $row->weight, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
            }

            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED ARRIVAL SHEET & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);

        } else {
            return redirect()->back();
        }
        // dd($arrivals);

    }
    public function manifist($id, Request $request)
    {

        $manifist_data = getAPIdata('manifists/single', ['company_id' => session('company_id'), 'manifist_id' => $id]);
        $manifist = $manifist_data->payload;
        // dd($manifist);
        if (count($manifist) > 0) {
            $pdf = $this->tc_init('ManifistSheet #' . $id);
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'MANIFIST SHEET', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SHEET NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $id, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'STATION:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $manifist[0]->station_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SEAL:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $manifist[0]->seal_no, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'BATCH:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $manifist[0]->batch_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, Carbon::parse($manifist[0]->created_at)->format('Y-m-d'), 0, 0, 'L', 1, '', 0, false, 'T', 'C');

            // tabel header
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details Of Manifist', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'Third Party No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Origin', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Destination', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(35.5, 5, 'Peice', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(35.9, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            foreach ($manifist as $key => $row) {
                // dd($row);
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, "$row->consignment_no", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, ($row->thirdparty_consignment_no == '' ? '-' : $row->thirdparty_consignment_no), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $this->city_name($row->oigin), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $this->city_name($row->destination), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.5, 5, $row->peices, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.9, 5, $row->weight, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
            }

            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED MANIFIST SHEET & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);

        } else {
            return redirect()->back();
        }
        // dd($arrivals);

    }
    public function de_manifist($id, Request $request)
    {
        $result = getAPIdata('de_manifists/single', ['company_id' => session('company_id'), 'id' => $id]);
        $demanifist = $result->payload;
        if (count($demanifist) > 0) {
            $pdf = $this->tc_init('DeManifistSheet #' . $id);
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'DE MANIFIST SHEET', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SHEET NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $id, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'STATION:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $demanifist[0]->station_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, Carbon::parse($demanifist[0]->created_at)->format('Y-m-d'), 0, 0, 'L', 1, '', 0, false, 'T', 'C');

            // tabel header
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details Of DeManifist', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'Third Party No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Origin', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Destination', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(35.5, 5, 'Peice', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(35.9, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            foreach ($demanifist as $key => $row) {
                // dd($row);
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, "$row->consignment_no", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, ($row->thirdparty_consignment_no == '' ? '-' : $row->thirdparty_consignment_no), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $this->city_name($row->origin), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $this->city_name($row->destination), 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.5, 5, $row->peices, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.9, 5, $row->weight, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
            }

            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED DE MANIFIST SHEET & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);

        } else {
            return redirect()->back();
        }
        // dd($arrivals);

    }
    // public function airway_bill($id, Request $request)
    // {
    //     get_all_status();
    //     $company_id = session('company_id');
    //     $cn_no = base64_decode($id);
    //     $data = compact('company_id', 'cn_no');
    //     $result = getAPIdata('customer_services/single', $data);
    //     $services = getAPIdata('common/getServices',['type' => 'all']);
    //     $service_collection = collect($services);
    //     if ($result->status == 1) {
    //         $pdf = $this->tc_init('Airway Bill');
    //         $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    //         $pdf::SetPrintHeader(false);
    //         $pdf::SetFillColor(255, 255, 255);
    //         $x = 173.5;
    //         $yy = 10.2;
    //         $y = 10.2;
    //         $y_b = -25;
    //         $w = 25;
    //         $h = 22.3;
    //         $cout = 0;
    //         $pg_no = 1;
    //         $third_party_count = 0;
    //         $third_party_count_loop = 0;
    //         foreach ($result->payload as $r) {
    //             if (preg_match("/[a-z]/i", $r->thirdparty_consignment_no)) {
    //                 $third_party_count++;
    //             }
    //         }
    //         $printCounter = 0;
    //         foreach ($result->payload as $r) {
    //             $service_type = $service_collection->where('id',$r->service_id)->pluck('service_name')->first();;
    //             $product_detail = $r->parcel_detail;
    //             $product_detail = preg_replace('#(\r|\r\n|\n)#', ' ', $product_detail);
    //             $cout++;
    //             $pdf::ln(-10);
    //             $pdf::SetAutoPageBreak(true, 0);
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             // $Qrdata=$r->thirdparty_consignment_no."\n".$r['cash_collect']."\n".$thirdparty_city;
    //             $Qrdata = $r->thirdparty_consignment_no . "\n" . $r->orignal_order_amt;
    //             $style = array(
    //                 'position' => 'center',
    //                 'align' => 'C',
    //                 'stretch' => false,
    //                 // 'fitwidth' => true,
    //                 'cellfitalign' => '',
    //                 'border' => 'auto',
    //                 'hpadding' => 5, // Changed from '5px' to 5
    //                 'vpadding' => 10, // Changed from '10px' to 10
    //                 'fgcolor' => array(0, 0, 0),
    //                 'bgcolor' => false, //array(255,255,255),
    //                 'text' => true,
    //                 'font' => 'helvetica',
    //                 'fontsize' => 8,
    //                 'stretchtext' => 3
    //             );

    //             if (session('company_logo') == 'orio-logo.svg') {
    //                 $IMAGE_PATH = asset('images/default/svg/orio-logo.png');
    //             } else {
    //                 $IMAGE_PATH = asset('images/' . session('company_id') . '/' . session('company_logo'));
    //             }
    //             $pdf::writeHTMLCell(22.7, 23, '', '', '<img src="' . $IMAGE_PATH . '" width="80">', 1, 0, true, true, 'T', 'B', false);
    //             $pdf::write1DBarcode("$r->consignment_no", 'C128A', 31, '', 50.4, 22, 0.4, $style, 'C');
    //             $pdf::ln(-13.7);
    //             $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
    //             $pdf::Cell(15, 4.0, 'Date', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(20.5, 4.0, Carbon::parse($r->created_at)->format('Y-m-d'), 1, 0, 'L', 1, '', 0, false, 'T', 'C');

    //             if ($r->thirdparty_consignment_no != null) {
    //                 if (preg_match("/[a-z]/i", $r->thirdparty_consignment_no)) {
    //                     $pdf::write1DBarcode($r->thirdparty_consignment_no, 'C128A', '', '', 81.5, 23, 0.5, $style, 'C');
    //                     $pdf::ln(-10.5);
    //                 } else {
    //                     $pdf::write1DBarcode($r->thirdparty_consignment_no, 'C128A', '', '', 81.5, 23, 0.5, $style, 'C');
    //                     $pdf::ln(-10.5);
    //                 }
    //             } else {
    //                 //poorii line ka else
    //                 $pdf::Cell(81.5, 30, '', 'LRT', 30, 'L', 10, '', 1, 1, 'T', 'C');
    //                 $pdf::ln(-25.9);
    //             }
    //             $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             $pdf::Cell(15, 4.5, 'Account', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 7);
    //             $pdf::Cell(20.5, 4.5, $r->customer_acno, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(4.5);
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             // $pdf::Cell(73.5, 4.5, '', 100,  'C', 0, '', 0, false, 'B', 'C');
    //             $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
    //             $pdf::Cell(15, 4.5, 'ORGN', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(20.5, 4.5, $r->origin_city, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(4.5);
    //             // $pdf::Cell(73.5, 4.5, '', 100,  'C', 0, '', 0, false, 'B', 'C');
    //             $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             $pdf::Cell(15, 4.5, 'DSTN', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(20.5, 4.5, $r->destination_city, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(4.5);
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             // $pdf::Cell(73.5, 4.5, '', 100,  'C', 0, '', 0, false, 'B', 'C');
    //             $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
    //             $pdf::Cell(15, 4.5, 'COD', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(20.5, 4.5, $r->orignal_order_amt . "/-" . $r->orignal_currency_code, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(1.5);
    //             $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $style = array(
    //                 'border' => 1,
    //                 'vpadding' => '2px',
    //                 'hpadding' => 'auto',
    //                 'fgcolor' => array(0, 0, 0),
    //                 'bgcolor' => false, //array(255,255,255)
    //                 'module_width' => 1, // width of a single module in points
    //                 'module_height' => 1
    //             );
    //             //===========================================QrCode===========================================
    //             if (preg_match("/[a-z]/i", $r->thirdparty_consignment_no)) {
    //                 $third_party_count_loop++;
    //                 // $pdf::write2DBarcode($Qrdata, 'QRCODE,L', 173.5, 10.2, 25, 22.3, $style, 'C');
    //             }
    //             //===========================================QrCode===========================================

    //             $pdf::ln(3);
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             $pdf::Cell(73.6, 5, 'Shipper Details', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(35.5, 5, 'Cash Collect Barcode', 1, 0, '', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(81.4, 4.8, 'Consignee Details', 1, 0, '', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(4);
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::ln(1);
    //             $pdf::MultiCell(73.6, 20, $r->shipper_name . "  /  " . $r->shipper_phone . "   /   " . $r->origin_city . "   /   " . $r->shipper_address, 'RL', 'L', 1, 0, '', '', true);
    //             $pdf::write1DBarcode($r->orignal_currency_code, 'C128A', 81.8, '', 35, 19, 0.4, $style, 'C');
    //             $pdf::MultiCell(81.5, 26, $r->consignee_name . "  /  " . $r->consignee_phone . "   /   " . $r->destination_city . "   /   " . $r->consignee_address, 'RL', 'L', 1, 0, 117, '', true);
    //             $pdf::ln(19);
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             $pdf::Cell(25, 5, 'Weight', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(25, 5, 'Pieces', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             // $pdf::Cell(23.6, 5, 'Service', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(23.6, 5, '', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(35.29, 5, 'Service Type', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(81.6, 5, 'Reference Number', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             // $pdf::Cell(32.5, 5, 'Allow To Open', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(5);
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(25, 5, ($r->weight_charged == "" ? $r->weight : $r->weight_charged), 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(25, 5, ($r->peices_charged == "" ? $r->peices : $r->peices_charged), 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(23.6, 5, '', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::Cell(35.29, 5, $service_type??'' , 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(81.6, 5, $r->shipment_referance, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             // $pdf::Cell(32.5, 5, $r['allow_to_open'], 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(5);
    //             // if ($r['tpcode']=='LEO') {
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             $pdf::Cell(190.5, 5, 'Product Detail', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(5);
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::MultiCell(190.5, 25, $product_detail, 'LR', 'L', 1, 0, '', '', true);
    //             $pdf::ln(15);
    //             $pdf::SetFont('helvetica', 'B', 8);
    //             $pdf::Cell(190.5, 5, 'Remarks', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(5);
    //             $pdf::SetFont('helvetica', '', 8);
    //             $pdf::Cell(190.5, 5, $r->shipper_comment, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             $pdf::ln(10);
    //             // $pdf::Cell(80, 5, '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', 10, 0, 'L', 1, '', 0, false, 'T', 'C');
    //             for ($i = 1; $i <= 95; $i++) {
    //                 $pdf::Cell(2, 2, ' - ', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
    //             }
    //             $pdf::ln(20);
    //             $printCounter++;
    //             if ($printCounter % 2 == 0) {
    //                 $pdf::AddPage();
    //                 $printCounter = 0;
    //             }
    //         }
    //         $pdf::lastPage();
    //         return $this->output($pdf);
    //     } else {
    //         return redirect()->back();
    //     }
    // }
    
    public function airway_bill($id, Request $request)
    {
        $company_id = '100004';
        $company_logo = 'y8scvg.jpg';
        $consignments = base64_decode($id);        
        $data = compact('company_id', 'consignments');
        $result = getAPIdata('shipment/getData', $data);
        $services = getAPIdata('common/getServices',['type' => 'all']);
        $service_collection = collect($services);
        if ($result->status == 1) {
            $pdf = $this->tc_init('Airway Bill');
            $pdf::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf::SetPrintHeader(false);
            $pdf::SetFillColor(255, 255, 255);
            $x = 173.5;
            $yy = 10.2;
            $y = 10.2;
            $y_b = -25;
            $w = 25;
            $h = 22.3;
            $cout = 0;
            $pg_no = 1;
            $third_party_count = 0;
            $third_party_count_loop = 0;
            foreach ($result->payload as $r) {
                if (preg_match("/[a-z]/i", $r->thirdparty_consignment_no)) {
                    $third_party_count++;
                }
            }
            $printCounter = 0;
            foreach ($result->payload as $r) {
                $service_type = $service_collection->where('id',$r->service_id)->pluck('service_name')->first();
                if($r->shipment_type != '1'){
                    $product_detail = $r->parcel_detail;
                    $product_detail = preg_replace('#(\r|\r\n|\n)#', ' ', $product_detail);
                }else{
                    $product_detail = "";
                    foreach ($r->product_details as $detail) {
                        $product_detail .= "$detail->product_detail | $detail->hs_code | $detail->qty ~ ";                        
                    }
                    $product_detail = rtrim($product_detail,' ~ ');
                }
                $cout++;
                $pdf::ln(-10);
                $pdf::SetAutoPageBreak(true, 0);
                $pdf::SetFont('helvetica', 'B', 8);
                $Qrdata = $r->thirdparty_consignment_no . "\n" . $r->orignal_order_amt;
                $style = array(
                    'position' => 'center',
                    'align' => 'C',
                    'stretch' => false,
                    // 'fitwidth' => true,
                    'cellfitalign' => '',
                    'border' => 'auto',
                    'hpadding' => 5, // Changed from '5px' to 5
                    'vpadding' => 10, // Changed from '10px' to 10
                    'fgcolor' => array(0, 0, 0),
                    'bgcolor' => false, //array(255,255,255),
                    'text' => true,
                    'font' => 'helvetica',
                    'fontsize' => 8,
                    'stretchtext' => 3
                );
                if ($company_logo == 'orio-logo.svg') {
                    $IMAGE_PATH = asset('images/default/svg/orio-logo.png');
                } else {
                    $IMAGE_PATH = asset('images/' . $company_id . '/' . $company_logo);
                }
                $pdf::writeHTMLCell(22.7, 23, '', '', '<img src="' . $IMAGE_PATH . '" width="80">', 1, 0, true, true, 'T', 'B', false);
                $pdf::write1DBarcode("$r->consignment_no", 'C128A', 31, '', 50.4, 22, 0.4, $style, 'C');
                $pdf::ln(-13.7);
                $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
                $pdf::Cell(15, 4.0, 'Date', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(20.5, 4.0, Carbon::parse($r->created_at)->format('Y-m-d'), 1, 0, 'L', 1, '', 0, false, 'T', 'C');

                if ($r->thirdparty_consignment_no != null) {
                    if (preg_match("/[a-z]/i", $r->thirdparty_consignment_no)) {
                        $pdf::write1DBarcode($r->thirdparty_consignment_no, 'C128A', '', '', 81.5, 23, 0.5, $style, 'C');
                        $pdf::ln(-10.5);
                    } else {
                        $pdf::write1DBarcode($r->thirdparty_consignment_no, 'C128A', '', '', 81.5, 23, 0.5, $style, 'C');
                        $pdf::ln(-10.5);
                    }
                } else {
                    //poorii line ka else
                    $pdf::Cell(81.5, 30, '', 'LRT', 30, 'L', 10, '', 1, 1, 'T', 'C');
                    $pdf::ln(-25.9);
                }
                $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', 'B', 8);
                $pdf::Cell(15, 4.5, 'Account', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 7);
                $pdf::Cell(20.5, 4.5, $r->customer_acno??"", 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(4.5);
                $pdf::SetFont('helvetica', 'B', 8);
                // $pdf::Cell(73.5, 4.5, '', 100,  'C', 0, '', 0, false, 'B', 'C');
                $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
                $pdf::Cell(15, 4.5, 'ORGN', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(20.5, 4.5, $r->origin_city, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(4.5);
                // $pdf::Cell(73.5, 4.5, '', 100,  'C', 0, '', 0, false, 'B', 'C');
                $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', 'B', 8);
                $pdf::Cell(15, 4.5, 'DSTN', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(20.5, 4.5, $r->destination_city, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(4.5);
                $pdf::SetFont('helvetica', 'B', 8);
                // $pdf::Cell(73.5, 4.5, '', 100,  'C', 0, '', 0, false, 'B', 'C');
                $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
                $pdf::Cell(15, 4.5, 'COD', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(20.5, 4.5, $r->orignal_order_amt . "/-" . $r->orignal_currency_code, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(1.5);
                $pdf::Cell(73.5, 4.0, '', 0, 0, 'C', 0, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $style = array(
                    'border' => 1,
                    'vpadding' => '2px',
                    'hpadding' => 'auto',
                    'fgcolor' => array(0, 0, 0),
                    'bgcolor' => false, //array(255,255,255)
                    'module_width' => 1, // width of a single module in points
                    'module_height' => 1
                );
                //===========================================QrCode===========================================
                if (preg_match("/[a-z]/i", $r->thirdparty_consignment_no)) {
                    $third_party_count_loop++;
                }
                //===========================================QrCode===========================================

                $pdf::ln(3);
                $pdf::SetFont('helvetica', 'B', 8);
                $pdf::Cell(73.6, 5, 'Shipper Details', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.5, 5, 'Cash Collect Barcode', 1, 0, '', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(81.4, 4.8, 'Consignee Details', 1, 0, '', 1, '', 0, false, 'T', 'C');
                $pdf::ln(4);
                $pdf::SetFont('helvetica', '', 8);
                $pdf::ln(1);
                $pdf::MultiCell(73.6, 20, $r->shipper_name . "  /  " . $r->shipper_phone . "   /   " . $r->origin_city . "   /   " . $r->shipper_address, 'RL', 'L', 1, 0, '', '', true);
                $pdf::write1DBarcode($r->orignal_currency_code, 'C128A', 81.8, '', 35, 19, 0.4, $style, 'C');
                $pdf::MultiCell(81.5, 26, $r->consignee_name . "  /  " . $r->consignee_phone . "   /   " . $r->destination_city . "   /   " . $r->consignee_address, 'RL', 'L', 1, 0, 117, '', true);
                $pdf::ln(19);
                $pdf::SetFont('helvetica', 'B', 8);
                $pdf::Cell(25, 5, 'Weight', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25, 5, 'Pieces', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                // $pdf::Cell(23.6, 5, 'Service', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(23.6, 5, '', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.29, 5, 'Service Type', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(81.6, 5, 'Reference Number', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                // $pdf::Cell(32.5, 5, 'Allow To Open', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(25, 5, ($r->weight_charged == "" ? $r->weight : $r->weight_charged), 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25, 5, ($r->peices_charged == "" ? $r->peices : $r->peices_charged), 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(23.6, 5, '', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.29, 5, $service_type??'' , 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(81.6, 5, $r->shipment_referance, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                // $pdf::Cell(32.5, 5, $r['allow_to_open'], 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
                // if ($r['tpcode']=='LEO') {
                $pdf::SetFont('helvetica', 'B', 8);
                $pdf::Cell(190.5, 5, 'Product Detail', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
                $pdf::SetFont('helvetica', '', 8);
                $pdf::MultiCell(190.5, 25, $product_detail, 'LR', 'L', 1, 0, '', '', true);
                $pdf::ln(15);
                $pdf::SetFont('helvetica', 'B', 8);
                $pdf::Cell(190.5, 5, 'Remarks', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
                $pdf::SetFont('helvetica', '', 8);
                $pdf::Cell(190.5, 5, $r->shipper_comment, 1, 0, 'L', 1, '', 0, false, 'T', 'C');
                $pdf::ln(10);
                // $pdf::Cell(80, 5, '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', 10, 0, 'L', 1, '', 0, false, 'T', 'C');
                for ($i = 1; $i <= 95; $i++) {
                    $pdf::Cell(2, 2, ' - ', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
                }
                $pdf::ln(20);
                $printCounter++;
                if ($printCounter % 2 == 0) {
                    $pdf::AddPage();
                    $printCounter = 0;
                }
            }
            $pdf::lastPage();
            return $this->output($pdf);
        } else {
            return redirect()->back();
        }
    }
    
    public function delivery_sheet($id, Request $request)
    {
        $company_id = (int) session('company_id');
        $sheet_no = (int) $id;
        $data = compact('company_id', 'sheet_no');
        $result = getAPIdata('delivery_sheet/single', $data);
        // dd($result);
        $peices_charged = $weight_charged = $total_cod = null;
        if ($result->status == 1) {
            $pdf = $this->tc_init('DELIVERY SHEET');
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 8, 8, 30);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 8, 8, 30);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'DELIVERY SHEET', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln();
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'ACCOUNT NAME:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '' . $result->payload[0]->business_name . ' (' . $result->payload[0]->acno . ')', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'SHEET NUMBER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, '#' . $sheet_no, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'RIDER:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $result->payload[0]->rider_first_name.' '. $result->payload[0]->rider_last_name, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'ROUTE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, $result->payload[0]->route_address, 0, 0, 'L', 1, '', 0, false, 'T', 'C');

            // tabel header
            $pdf::ln(5);
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Referance Status', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(15.5, 5, 'Delivered', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(15.5, 5, 'Refused', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(44.5, 5, 'Address Closed / Untraceable', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(35.5, 5, 'Customer not Available', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(24.5, 5, 'Payment Issue', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(30.5, 5, 'Incomplete Address', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(25.5, 5, 'Address Changed', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::Cell(45.1, 5, '', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(30.5, 5, 'No Such Consignee', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(30.5, 5, 'Fake / Double Order', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(40.5, 5, 'Hold on Customer Request', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(45.1, 5, '', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::ln(5);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Consignment No', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(26.5, 5, 'Consignee Name', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'Consignee Phone', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(35.5, 5, 'Reference', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(18.5, 5, 'Status', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(10.5, 5, 'Peice', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(10.5, 5, 'Weight', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(15.5, 5, 'Currency', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(10.5, 5, 'Total', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            foreach ($result->payload as $key => $row) {
                $cod = "";
                $weight_charged += $row->weight_charged;
                $peices_charged += $row->peices_charged;
                if($row->status == '16')
                {
                    $charges = $row->gst_charges+$row->sst_charges+$row->bac_charges+$row->handling_charges+$row->rto_charges;
                }else{
                    $charges = $row->gst_charges+$row->sst_charges+$row->bac_charges+$row->handling_charges+$row->service_charges;
                }

                $cod = $row->orignal_order_amt + $charges; 
                $total_cod += $row->orignal_order_amt + $charges; 

                $pdf::ln(5);
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, "$row->consignment_no", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(26.5, 5, $row->consignee_name, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, $row->consignee_phone, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.5, 5, $row->shipment_referance, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(18.5, 5, session('status')[$row->status - 1]->name, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(10.5, 5, $row->peices_charged, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(10.5, 5, $row->weight_charged, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(15.5, 5, $row->orignal_currency_code, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
           
                $pdf::Cell(10.5, 5, $cod, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                

            }
            $pdf::ln(5);
            $pdf::setCellPadding(1);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(144.5, 5, 'TOTAL PEICES', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(10.5, 5, $peices_charged, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(36.6, 5, '', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(155.1, 5, 'TOTAL WEIGHT', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(10.5, 5, $weight_charged, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(26, 5, '', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(165.5, 5, 'TOTAL COD', 1, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell(26, 5, $result->payload[0]->orignal_currency_code.' ' . $total_cod, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED DELIVERY SHEET & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);

        } else {
            return redirect()->back();
        }
    }

    public function proforma_invoice($id, Request $request)
    {
        get_all_status();
        $company_id = session('company_id');
        $consignments = base64_decode($id);
        $data = compact('company_id', 'consignments');
        $result = getAPIdata('shipment/getData', $data);
        if ($result->status == 1) {
            $payload = $result->payload[0];
            // dd($result->payload[0]);
            $pdf = $this->tc_init('Proforma Invoice');
            if (session('company_logo') == 'orio-logo.svg') {
                $pdf::Image(asset('images/default/svg/orio-logo.png'), 7, 8, 40);
            } else {
                $pdf::Image(asset('images/' . session('company_id') . '/' . session('company_logo')), 7, 8, 40);
            }
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 11);
            $pdf::Cell(193, 5, 'Consignment Number # '.$payload->consignment_no, 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(7);
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell(48.5, 5, 'BOOKING DATE:', 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8);
            $pdf::Cell(20.5, 5, Carbon::parse($payload->created_at)->format('Y-m-d'), 0, 0, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::ln(6);

            // Set initial X and Y coordinates
            $startX = $pdf::GetX();
            $startY = $pdf::GetY();

            // Calculate column width
            $columnWidth = 95; // Adjust this value based on your needs
            $lineHeight = 6;

            // First column - Shipper Details
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell($columnWidth, 5, 'Shipper Details', 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', '', 8.3);
            $pdf::Cell($columnWidth, 5, 'NAME : '.$payload->shipper_name, 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell($columnWidth, 5, 'PHONE : '.$payload->shipper_phone, 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell($columnWidth, 5, 'EMAIL : '.$payload->shipper_email, 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell($columnWidth, 5, 'CNIC : '.$payload->shipper_cnic, 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell($columnWidth, 5, 'POSTAL CODE : '.$payload->shipper_postalcode, 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            $pdf::Cell($columnWidth, 5, 'ADDRESS : '.$payload->shipper_address, 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            // Set position for Consignee Details heading
            $pdf::SetXY($startX + $columnWidth + 10, $startY);

            // Second column - Consignee Details
            $pdf::SetFont('helvetica', 'B', 8.3);
            $pdf::Cell($columnWidth, 5, 'Consignee Details', 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            // Reset font and set position for first line of consignee details
            $pdf::SetFont('helvetica', '', 8.3);
            $pdf::SetXY($startX + $columnWidth + 10, $startY + 5);
            $pdf::Cell($columnWidth, 5, 'NAME : '.$payload->consignee_name, 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            $pdf::SetX($startX + $columnWidth + 10);
            $pdf::Cell($columnWidth, 5, 'PHONE : '.$payload->consignee_phone, 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            $pdf::SetX($startX + $columnWidth + 10);
            $pdf::Cell($columnWidth, 5, 'EMAIL : '.$payload->consignee_email, 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            $pdf::SetX($startX + $columnWidth + 10);
            $pdf::Cell($columnWidth, 5, 'CNIC : '.$payload->consignee_cnic, 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            $pdf::SetX($startX + $columnWidth + 10);
            $pdf::Cell($columnWidth, 5, 'POSTAL CODE : '.$payload->consignee_postalcode, 0, 1, 'L', 1, '', 0, false, 'T', 'C');

            $pdf::SetX($startX + $columnWidth + 10);
            $pdf::Cell($columnWidth, 5, 'ADDRESS : '.$payload->consignee_address, 0, 1, 'L', 1, '', 0, false, 'T', 'C');
            // Reset position for next content
            $pdf::SetXY($startX, $startY + 35);
            
            // tabel header
            $pdf::ln(5);
            $pdf::SetFont('helvetica', 'B', 10);
            $pdf::Cell(191.6, 5, 'Details Of Shipments', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            // headere cxoloums 
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(8.1, 5, 'Sr#', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(66.5, 5, 'Product Detail', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(30.5, 5, 'HS Code', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'Value', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(25.5, 5, 'QTY', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(35.5, 5, 'Amount', 1, 0, 'C', 1, '', 0, false, 'T', 'C');
            $pdf::ln(5);
            foreach ($payload->product_details as $key => $row) {
                $pdf::Cell(8.1, 5, $key + 1, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(66.5, 5, "$row->product_detail", 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(30.5, 5, $row->hs_code, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $row->value, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(25.5, 5, $row->qty, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::Cell(35.5, 5, $row->amount, 1, 0, 'C', 1, '', 0, false, 'T', 'C');
                $pdf::ln(5);
            }

            $pdf::ln(6);
            $pdf::SetFont('helvetica', 'B', 8);
            $pdf::Cell(193, 5, 'NOTE: THIS IS COMPUTER GENERATED PROFOMA INVOICE & DOES NOT NEED SIGNATURE & STAMP.', 0, 0, 'C', 1, '', 0, false, 'T', 'C');
            // 3PL Print

            $pdf::setCellPadding(0);
            return $this->output($pdf);

        } else {
            return redirect()->back();
        }
        // dd($arrivals);

    }
}
