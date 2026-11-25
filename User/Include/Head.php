<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund X || User Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap/dist/css/jsvectormap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@flaticon/flaticon-uicons/css/all/all.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        #toast {
            position: fixed;
            top: 20px;
            right: -300px;
            background: #22c55e;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 600;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
            transition: right 0.4s ease;
            z-index: 9999;
        }

        #toast.show {
            right: 20px;
        }
    </style>
    <style>
        .table-box {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table.dataTable thead {
            background: #4e73df;
            color: white;
        }

        table.dataTable thead th {
            text-align: center;
            padding: 12px;
        }

        table.dataTable tbody td {
            padding: 10px;
        }

        /* Alignment */
        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        /* Fix search + length alignment */
        div.dataTables_wrapper .dataTables_length {
            float: left;
        }

        div.dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }

        div.dataTables_wrapper .dataTables_info {
            float: left;
            margin-top: 10px;

        }

        div.dataTables_wrapper .dataTables_paginate {
            float: right;
            margin-top: 10px;
        }

        /* Clear floats */
        .dataTables_wrapper::after {
            content: "";
            display: block;
            clear: both;
        }

        /* Fix DataTable layout */
        .dataTables_wrapper {
            color: #fff;
        }

        /* Top section (Show + Search) */
        .dataTables_wrapper .dataTables_length {
            float: left;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            margin-bottom: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            background: #0f172a;
            border: 1px solid #334155;
            color: #fff;
            padding: 5px 10px;
            border-radius: 6px;
        }

        /* Fix "Show entries" inline */
        .dataTables_wrapper .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Table styling */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        table.dataTable thead {
            background: #020617;
        }

        table.dataTable thead th {
            text-align: center;
            color: #f6dd3b;
            border-bottom: 1px solid #1e293b;
        }

        table.dataTable tbody td {
            text-align: center;
            color: #cbd5f5;
        }

        /* Pagination + info */
        .dataTables_wrapper .dataTables_info {
            float: left;
            margin-top: 10px;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right;
            margin-top: 10px;
        }

        /* Clear float */
        .dataTables_wrapper::after {
            content: "";
            display: block;
            clear: both;
        }

        .dataTables_wrapper .dataTables_length select {
            background: #000 !important;
            color: #fff;
        }

        /* Card */
        .payment-card {
            width: 95%;
            height: 20%;
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            background: linear-gradient(145deg, #0f172a, #111827);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6),
                inset 0 0 20px rgba(255, 255, 255, 0.03);
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        /* Glow border */
        .payment-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 20px;
            padding: 1px;
            background: linear-gradient(120deg, #f6dd3b, transparent, #f6dd3b);
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        /* Title */
        .payment-card h3 {
            font-size: 14px;
            /* margin-bottom: 20px; */
            color: #e5e7eb;
        }

        /* Shield icon container */
        .icon-boxnav {
            position: relative;
            /* margin: 20px auto; */
            width: 100%;
            height: 80px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.4), transparent 70%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Shield */
        .icon-box i {
            font-size: 40px;
            color: #f6dd3b;
            z-index: 2;
        }

        /* Glow dots */
        .icon-box::after {
            content: "";
            position: absolute;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2), transparent 70%);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.2);
                opacity: 0;
            }
        }

        /* Subtitle */
        .payment-card p {
            font-size: 16px;
            /* margin: 15px 0; */
            color: #d1d5db;
            font-weight: 500;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 8px 14px;
            margin: 3px;
            background: #1e293b;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .pagination a:hover {
            background: #000;
        }

        .pagination a.active {
            background: #f6dd3b;
            color: #fff;
            font-weight: bold;
        }

        .split-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        /* LEFT CONTENT */
        .content-side {
            flex: -1;
        }

        .content-side h3 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .content-side p {
            color: #94a3b8;
            margin-bottom: 15px;
        }

        /* RIGHT IMAGE */
        .image-side {
            flex: 1;
            text-align: right;
        }

        .image-side img {
            max-width: 100%;
            height: auto;
            max-height: 140px;
            object-fit: contain;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .split-box {
                /*flex-direction: column;*/
                text-align: center;
            }

            .image-side {
                text-align: center;
            }

            .image-side img {
                max-height: 120px;
            }
        }

        /* Payment buttons */
    </style>
</head>

<body>