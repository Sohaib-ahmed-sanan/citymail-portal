<?php
$baseUrl = config('app.url');
?>
<script>
    const BASEURL = '<?= $baseUrl; ?>/';
</script>
<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $title }} | CITY MAIL</title>
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon.png') }}">
    <meta name="msapplication-tap-highlight" content="no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bamburgh.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/scroller.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/md-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.dataTables.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.bootstrap.css"/>
</head>
@php
    $primary = session('primary_color');
    $secondary = session('secondary_color');
    $font = session('font_color');
@endphp
<style>
    .btn-orio,.btn-primary,.btn-create{
        background-color: <?= $primary ?> !important;
        border-color:  <?= $primary ?> !important;
        border-radius : 8px;
    }
    .daterangepicker.ranges li.active,.daterangepicker td.active{
        background-color: <?= $primary ?> !important;
    }

    .btn-secondary-orio,.btn-secondary{
        border: none !important;
        background: <?= $secondary?> !important;
        color: #4e4d4d !important;
    }
    body,a,.app-sidebar--light .sidebar-navigation ul,.breadcrumb li,.breadcrumb-item {
        color: <?= $font ?> !important
    }
</style>

<body id="app-top">
    <div class="app-wrapper">