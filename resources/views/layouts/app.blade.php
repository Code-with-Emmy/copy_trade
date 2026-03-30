<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@php
    $isAdminShell = request()->is('admin*') || request()->routeIs('admin.*') || auth('admin')->check();
@endphp

<head>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $settings->site_name }} | {{ $title }}</title>
    <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/png" />
    @if ($isAdminShell)
        <link rel="stylesheet" href="{{ asset('styles.css') }}">
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endif

    @section('styles')
    <script src="unpkg.com/metaapi.cloud-sdk/index.js"></script>
    <!-- Fonts and icons -->
    <script src="{{ asset('dash/js/plugin/webfont/webfont.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }} "></script>
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('dash/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/css/fonts.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @php
        $theme = $settings->website_theme == 'blue.css' ? 'atlantis.min.css' : $settings->website_theme;
    @endphp
    <link rel="stylesheet" href="{{ asset('dash/css/' . $theme) }}">
    <link rel="stylesheet" href="{{ asset('dash/css/customs.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/css/style.css') }}">
    {{--
    <link rel="stylesheet" href="{{ asset('dash/css/atlantis.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('dash/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }} "></script>
    <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }} "></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
    {{--
    <script src="{{ asset('js/app.js') }}"></script> --}}
    <!--PayPal-->
    <script>
        // Add your client ID and secret
        var PAYPAL_CLIENT = '{{ $settings->pp_ci }}';
        var PAYPAL_SECRET = '{{ $settings->pp_cs }}';

        // Point your server to the PayPal API
        var PAYPAL_ORDER_API = 'https://api.paypal.com/v2/checkout/orders/';
    </script>
    <script src="https://www.paypal.com/sdk/js?client-id={{ $settings->pp_ci }}"></script>
    @show
    @if ($isAdminShell)
        <style>
            :root {
                --admin-bg: #070b12;
                --admin-surface: rgba(11, 18, 32, 0.96);
                --admin-surface-soft: rgba(15, 23, 42, 0.9);
                --admin-border: rgba(148, 163, 184, 0.12);
                --admin-border-strong: rgba(255, 255, 255, 0.12);
                --admin-text: #e2e8f0;
                --admin-text-muted: #94a3b8;
                --admin-heading: #f8fafc;
                --admin-accent: #f0b90a;
                --admin-accent-2: #0ea5e9;
                --admin-success: #10b981;
                --admin-danger: #ef4444;
            }

            body.admin-app-shell {
                background:
                    radial-gradient(circle at top left, rgba(14, 165, 233, 0.10), transparent 26%),
                    radial-gradient(circle at top right, rgba(240, 185, 10, 0.08), transparent 24%),
                    linear-gradient(180deg, #06090f 0%, #0b1220 100%);
                color: var(--admin-text);
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                overflow-x: hidden;
            }

            .admin-app-shell .dashboard-glass {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(240, 185, 10, 0.05);
                border-radius: 20px;
                box-shadow: 0 24px 60px -46px rgba(0, 0, 0, 0.9);
            }

            .admin-app-shell .gold-text {
                color: var(--admin-accent);
            }

            .admin-app-shell .gold-gradient-bg {
                background: linear-gradient(135deg, #f0b90a, #d4a017);
            }

            .admin-app-shell .page-shell {
                width: 100%;
                max-width: 1520px;
                margin: 0 auto;
            }

            .admin-app-shell .page-content-stack {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .admin-app-shell .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .admin-app-shell .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .admin-app-shell .wrapper {
                background: transparent;
            }

            .admin-app-shell .main-panel {
                width: auto;
                min-height: 100vh;
                margin-left: 280px;
                background: transparent;
                transition: margin-left .2s ease;
            }

            .admin-app-shell .content {
                background: transparent !important;
                padding-top: 0.5rem;
            }

            .admin-app-shell .page-inner {
                padding: 1.5rem 1.5rem 2rem !important;
            }

            .admin-app-shell .footer {
                margin-left: 280px;
                border-top: 1px solid var(--admin-border);
                background: rgba(7, 11, 18, 0.78);
                backdrop-filter: blur(10px);
            }

            .admin-app-shell .footer p,
            .admin-app-shell .footer .copyright {
                color: var(--admin-text-muted);
                margin: 0;
            }

            .admin-app-shell .card,
            .admin-app-shell .panel,
            .admin-app-shell .modal-content {
                border: 1px solid var(--admin-border) !important;
                border-radius: 24px !important;
                background: linear-gradient(180deg, rgba(15, 23, 42, 0.96), rgba(9, 14, 24, 0.98)) !important;
                box-shadow: 0 28px 60px -40px rgba(2, 6, 23, 0.95);
                color: var(--admin-text);
            }

            .admin-app-shell .card-header,
            .admin-app-shell .modal-header,
            .admin-app-shell .card-footer {
                background: transparent !important;
                border-color: var(--admin-border) !important;
                padding: 1.15rem 1.3rem;
            }

            .admin-app-shell .card-body,
            .admin-app-shell .modal-body {
                padding: 1.25rem 1.3rem;
            }

            .admin-app-shell .card-title,
            .admin-app-shell .modal-title,
            .admin-app-shell h1,
            .admin-app-shell h2,
            .admin-app-shell h3,
            .admin-app-shell h4,
            .admin-app-shell h5,
            .admin-app-shell h6 {
                color: var(--admin-heading);
            }

            .admin-app-shell p,
            .admin-app-shell small,
            .admin-app-shell label,
            .admin-app-shell .text-muted,
            .admin-app-shell .form-text {
                color: var(--admin-text-muted) !important;
            }

            .admin-app-shell .table {
                color: var(--admin-text);
                margin-bottom: 0;
            }

            .admin-app-shell .table thead th {
                border-bottom: 1px solid var(--admin-border) !important;
                border-top: 0 !important;
                color: #7dd3fc;
                font-size: .72rem;
                font-weight: 800;
                letter-spacing: .16em;
                text-transform: uppercase;
                background: rgba(255, 255, 255, 0.02);
            }

            .admin-app-shell .table td,
            .admin-app-shell .table th {
                border-color: var(--admin-border) !important;
                vertical-align: middle;
            }

            .admin-app-shell .table-bordered,
            .admin-app-shell .table-bordered td,
            .admin-app-shell .table-bordered th {
                border-color: var(--admin-border) !important;
            }

            .admin-app-shell .table-responsive,
            .admin-app-shell .dataTables_wrapper,
            .admin-app-shell .widget-shadow,
            .admin-app-shell .bs-example {
                border-radius: 22px;
            }

            .admin-app-shell .table-striped tbody tr:nth-of-type(odd),
            .admin-app-shell .table-hover tbody tr:hover {
                background: rgba(255, 255, 255, 0.03) !important;
            }

            .admin-app-shell .form-control,
            .admin-app-shell .custom-select,
            .admin-app-shell .select2-container--default .select2-selection--single,
            .admin-app-shell .input-group-text,
            .admin-app-shell textarea,
            .admin-app-shell select {
                min-height: 48px;
                border: 1px solid var(--admin-border) !important;
                border-radius: 16px !important;
                background: rgba(15, 23, 42, 0.72) !important;
                color: #fff !important;
                box-shadow: none !important;
            }

            .admin-app-shell textarea.form-control {
                min-height: 120px;
            }

            .admin-app-shell .form-control:focus,
            .admin-app-shell .custom-select:focus,
            .admin-app-shell textarea:focus,
            .admin-app-shell select:focus {
                border-color: rgba(240, 185, 10, 0.45) !important;
                box-shadow: 0 0 0 0.2rem rgba(240, 185, 10, 0.14) !important;
            }

            .admin-app-shell .input-group-text {
                color: var(--admin-text-muted) !important;
            }

            .admin-app-shell .btn {
                border-radius: 999px;
                padding: .72rem 1.1rem;
                font-weight: 800;
                letter-spacing: .06em;
                transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
            }

            .admin-app-shell .btn:hover {
                transform: translateY(-1px);
            }

            .admin-app-shell .btn-primary,
            .admin-app-shell .bg-primary {
                border-color: transparent !important;
                background: linear-gradient(135deg, var(--admin-accent), #d97706) !important;
                color: #0f172a !important;
                box-shadow: 0 18px 34px -24px rgba(240, 185, 10, 0.8);
            }

            .admin-app-shell .btn-secondary,
            .admin-app-shell .btn-outline-light,
            .admin-app-shell .btn-light {
                border-color: var(--admin-border-strong) !important;
                background: rgba(255, 255, 255, 0.04) !important;
                color: #fff !important;
            }

            .admin-app-shell .btn-success {
                border-color: transparent !important;
                background: linear-gradient(135deg, #10b981, #059669) !important;
            }

            .admin-app-shell .btn-danger {
                border-color: transparent !important;
                background: linear-gradient(135deg, #ef4444, #dc2626) !important;
            }

            .admin-app-shell .btn-info {
                border-color: transparent !important;
                background: linear-gradient(135deg, #38bdf8, #0ea5e9) !important;
                color: #082f49 !important;
            }

            .admin-app-shell .btn-warning {
                border-color: transparent !important;
                background: linear-gradient(135deg, #facc15, #f59e0b) !important;
                color: #422006 !important;
            }

            .admin-app-shell .btn-outline-primary,
            .admin-app-shell .btn-outline-secondary,
            .admin-app-shell .btn-outline-info,
            .admin-app-shell .btn-outline-success,
            .admin-app-shell .btn-outline-danger {
                background: rgba(255, 255, 255, 0.03) !important;
                color: #fff !important;
                border-color: var(--admin-border-strong) !important;
            }

            .admin-app-shell .badge,
            .admin-app-shell .label {
                border-radius: 999px;
                padding: .45rem .75rem;
                font-weight: 800;
                letter-spacing: .08em;
                text-transform: uppercase;
            }

            .admin-app-shell .badge-success,
            .admin-app-shell .label-success {
                background: rgba(16, 185, 129, 0.14) !important;
                color: #a7f3d0 !important;
            }

            .admin-app-shell .badge-danger,
            .admin-app-shell .label-danger {
                background: rgba(239, 68, 68, 0.14) !important;
                color: #fecaca !important;
            }

            .admin-app-shell .badge-warning,
            .admin-app-shell .label-warning {
                background: rgba(250, 204, 21, 0.14) !important;
                color: #fde68a !important;
            }

            .admin-app-shell .badge-info,
            .admin-app-shell .label-info,
            .admin-app-shell .badge-primary,
            .admin-app-shell .label-primary {
                background: rgba(56, 189, 248, 0.14) !important;
                color: #bae6fd !important;
            }

            .admin-app-shell .page-title,
            .admin-app-shell .title1 {
                color: var(--admin-heading);
            }

            .admin-app-shell .page-header {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin-bottom: 1.35rem;
                padding: 1.35rem 1.45rem;
                border: 1px solid var(--admin-border);
                border-radius: 26px;
                background:
                    radial-gradient(circle at top right, rgba(240, 185, 10, 0.1), transparent 26%),
                    linear-gradient(145deg, rgba(12, 19, 32, 0.94), rgba(8, 13, 23, 0.96));
                box-shadow: 0 28px 60px -40px rgba(2, 6, 23, 0.95);
            }

            .admin-app-shell .breadcrumbs {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: .7rem;
                margin: .45rem 0 0;
                padding: 0;
                list-style: none;
            }

            .admin-app-shell .breadcrumbs .separator,
            .admin-app-shell .breadcrumbs .nav-home,
            .admin-app-shell .breadcrumbs .nav-item {
                color: var(--admin-text-muted);
                font-size: .78rem;
                font-weight: 700;
            }

            .admin-app-shell .breadcrumbs a {
                color: #cbd5f5;
            }

            .admin-app-shell .card-stats {
                overflow: hidden;
                position: relative;
            }

            .admin-app-shell .card-stats::before {
                content: "";
                position: absolute;
                inset: auto -2rem -2rem auto;
                width: 8rem;
                height: 8rem;
                border-radius: 999px;
                background: radial-gradient(circle, rgba(240, 185, 10, 0.14), transparent 70%);
                pointer-events: none;
            }

            .admin-app-shell .card-stats .card-category {
                margin-bottom: .3rem;
                color: var(--admin-text-muted) !important;
                font-size: .72rem;
                font-weight: 800;
                letter-spacing: .14em;
                text-transform: uppercase;
            }

            .admin-app-shell .card-stats .card-title {
                margin-bottom: 0;
                font-size: clamp(1.4rem, 1.6vw, 2rem);
                font-weight: 900;
                letter-spacing: -.03em;
            }

            .admin-app-shell .card-stats .icon-big {
                width: 3.6rem;
                height: 3.6rem;
                border-radius: 1.25rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.08);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.04);
            }

            .admin-app-shell .card-stats .icon-big i {
                font-size: 1.2rem;
            }

            .admin-app-shell .title1 {
                font-size: clamp(1.45rem, 2vw, 2rem);
                font-weight: 800;
                letter-spacing: -.02em;
                margin-bottom: .4rem;
            }

            .admin-app-shell .page-inner > .mt-2.mb-4,
            .admin-app-shell .page-inner > .mb-4,
            .admin-app-shell .page-inner > .mb-5:first-child,
            .admin-app-shell .page-inner > .row + .row {
                position: relative;
            }

            .admin-app-shell a {
                color: #7dd3fc;
                text-decoration: none !important;
            }

            .admin-app-shell a:hover {
                color: #bae6fd;
                text-decoration: none !important;
            }

            .admin-app-shell .border-white\/5,
            .admin-app-shell .border-white\/10 {
                border-color: rgba(240, 185, 10, 0.04) !important;
            }

            .admin-app-shell .border-b.border-white\/5,
            .admin-app-shell .border-t.border-white\/5,
            .admin-app-shell .border-b.border-white\/10,
            .admin-app-shell .border-t.border-white\/10 {
                border-color: rgba(240, 185, 10, 0.04) !important;
            }

            .admin-app-shell .alert {
                border-radius: 20px;
                border: 1px solid var(--admin-border);
                background: rgba(255, 255, 255, 0.04);
                color: var(--admin-text);
            }

            .admin-app-shell .dataTables_wrapper .dataTables_filter input,
            .admin-app-shell .dataTables_wrapper .dataTables_length select {
                margin-left: .5rem;
                padding: .55rem .8rem;
                min-height: 40px;
            }

            .admin-app-shell .dropdown-menu {
                border-radius: 18px;
            }

            .admin-app-shell .nav-tabs,
            .admin-app-shell .nav-pills {
                gap: .45rem;
                border-bottom-color: var(--admin-border) !important;
            }

            .admin-app-shell .nav-tabs .nav-link,
            .admin-app-shell .nav-pills .nav-link {
                border: 1px solid transparent;
                border-radius: 999px;
                color: var(--admin-text-muted);
                font-weight: 700;
                padding: .7rem 1rem;
            }

            .admin-app-shell .nav-tabs .nav-link.active,
            .admin-app-shell .nav-pills .nav-link.active {
                color: #fff !important;
                border-color: rgba(240, 185, 10, 0.24) !important;
                background: linear-gradient(135deg, rgba(240, 185, 10, 0.14), rgba(217, 119, 6, 0.12)) !important;
            }

            .admin-app-shell .pagination {
                gap: .45rem;
                align-items: center;
            }

            .admin-app-shell .page-item .page-link,
            .admin-app-shell .pagination li a,
            .admin-app-shell .pagination li span {
                border: 1px solid var(--admin-border) !important;
                border-radius: 14px !important;
                background: rgba(255, 255, 255, 0.03) !important;
                color: var(--admin-text) !important;
                min-width: 42px;
                text-align: center;
            }

            .admin-app-shell .page-item.active .page-link {
                background: linear-gradient(135deg, var(--admin-accent), #d97706) !important;
                border-color: transparent !important;
                color: #0f172a !important;
            }

            .admin-app-shell .modal-content .close,
            .admin-app-shell .close {
                color: #fff !important;
                opacity: .8;
                text-shadow: none;
            }

            .admin-app-shell .modal-content .close:hover,
            .admin-app-shell .close:hover {
                opacity: 1;
            }

            .admin-app-shell .list-group-item,
            .admin-app-shell .list-group-item-action {
                background: transparent !important;
                border-color: var(--admin-border) !important;
                color: var(--admin-text) !important;
            }

            .admin-app-shell .custom-file-label,
            .admin-app-shell .custom-file-label::after {
                border-radius: 16px !important;
                background: rgba(15, 23, 42, 0.72) !important;
                border-color: var(--admin-border) !important;
                color: var(--admin-text) !important;
            }

            .admin-app-shell .progress {
                height: .7rem;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.05);
            }

            .admin-app-shell .breadcrumb {
                background: transparent !important;
                padding: 0;
            }

            .admin-app-shell .breadcrumb-item + .breadcrumb-item::before {
                color: var(--admin-text-muted);
            }

            .admin-app-shell .select2-dropdown,
            .admin-app-shell .select2-results__option {
                background: #0f172a !important;
                color: #e2e8f0 !important;
            }

            .admin-app-shell .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background: rgba(240, 185, 10, 0.18) !important;
                color: #fff !important;
            }

            .admin-app-shell .select2-container--default .select2-selection--single .select2-selection__rendered,
            .admin-app-shell .select2-container--default .select2-selection--multiple .select2-selection__rendered {
                color: #fff !important;
                line-height: 46px !important;
                padding-left: 14px !important;
            }

            .admin-app-shell .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 46px !important;
            }

            .admin-app-shell .dataTables_wrapper .dataTables_info,
            .admin-app-shell .dataTables_wrapper .dataTables_paginate,
            .admin-app-shell .dataTables_wrapper .dataTables_length,
            .admin-app-shell .dataTables_wrapper .dataTables_filter {
                color: var(--admin-text-muted) !important;
                padding-top: 1rem;
            }

            .admin-app-shell .page-inner .row {
                row-gap: .5rem;
            }

            .admin-app-shell .page-inner .card.shadow,
            .admin-app-shell .page-inner .shadow {
                box-shadow: 0 28px 60px -40px rgba(2, 6, 23, 0.95) !important;
            }

            .admin-app-shell .page-inner .card-header > .row,
            .admin-app-shell .page-inner .card-footer > .row {
                row-gap: .85rem;
                align-items: center;
            }

            .admin-app-shell .page-inner .card-body > .table-responsive {
                margin: -.1rem;
            }

            .admin-page-header {
                display: flex;
                flex-wrap: wrap;
                align-items: flex-end;
                justify-content: space-between;
                gap: 1rem;
                padding: 1.35rem 1.45rem;
                margin-bottom: 1.25rem;
                border: 1px solid var(--admin-border);
                border-radius: 26px;
                background:
                    radial-gradient(circle at top right, rgba(240, 185, 10, 0.1), transparent 26%),
                    linear-gradient(145deg, rgba(12, 19, 32, 0.94), rgba(8, 13, 23, 0.96));
                box-shadow: 0 28px 60px -40px rgba(2, 6, 23, 0.95);
            }

            .admin-page-kicker {
                display: inline-flex;
                align-items: center;
                gap: .45rem;
                margin-bottom: .5rem;
                padding: .35rem .75rem;
                border-radius: 999px;
                border: 1px solid rgba(240, 185, 10, 0.18);
                background: rgba(240, 185, 10, 0.08);
                color: #fde68a;
                font-size: .68rem;
                font-weight: 800;
                letter-spacing: .12em;
                text-transform: uppercase;
            }

            .admin-page-subtitle {
                max-width: 720px;
                margin: .4rem 0 0;
                color: var(--admin-text-muted) !important;
                line-height: 1.65;
            }

            .admin-page-actions {
                display: flex;
                flex-wrap: wrap;
                gap: .65rem;
            }

            .admin-app-shell .table-light,
            .admin-app-shell .table-light > td,
            .admin-app-shell .table-light > th {
                background: rgba(240, 185, 10, 0.08) !important;
            }

            .admin-app-shell .dt-buttons {
                display: flex;
                flex-wrap: wrap;
                gap: .55rem;
                margin-bottom: 1rem;
            }

            .admin-app-shell .dt-button {
                border: 1px solid var(--admin-border-strong) !important;
                border-radius: 999px !important;
                background: rgba(255, 255, 255, 0.04) !important;
                color: #fff !important;
                padding: .72rem 1rem !important;
                font-weight: 800 !important;
                letter-spacing: .08em !important;
                text-transform: uppercase;
                box-shadow: none !important;
            }

            .admin-app-shell .dt-button:hover {
                background: rgba(255, 255, 255, 0.08) !important;
                color: #fff !important;
            }

            .admin-app-shell .btn-group > .btn {
                border-radius: 999px !important;
            }

            .admin-app-shell .btn-group > .btn + .btn,
            .admin-app-shell .btn-group > .btn + .btn-group,
            .admin-app-shell .btn-group > .btn-group + .btn,
            .admin-app-shell .btn-group > .btn-group + .btn-group {
                margin-left: .45rem;
            }

            @media (max-width: 991.98px) {
                .admin-app-shell .main-panel,
                .admin-app-shell .footer {
                    margin-left: 0;
                }

                .admin-app-shell .page-inner {
                    padding: 1rem 1rem 1.5rem !important;
                }
            }

            @media (min-width: 1024px) {
                .admin-app-shell .page-content-stack {
                    gap: 2.5rem;
                }
            }
        </style>
    @endif
    @livewireStyles
</head>

<body data-background-color="light" class="{{ $isAdminShell ? 'admin-app-shell antialiased' : '' }}" @if ($isAdminShell) x-data="{ sidebarOpen: false, fabOpen: false }" @endif>

    <div id="app">
        <div>
            <div class="wrapper">
                @yield('content')
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="text-center row copyright text-align-center">
                            <p>All Rights Reserved &copy; {{ $settings->site_name }} {{ date('Y') }}</p> <br>

                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    @livewireScripts
    @section('scripts')
    <!--   Core JS Files   -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{--
    <script src="{{ asset('dash/js/core/jquery.3.2.1.min.js')}} "></script> --}}
    <script src="{{ asset('dash/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('dash/js/core/bootstrap.min.js') }} "></script>
    <!-- jQuery UI -->
    <script src="{{ asset('dash/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dash/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('dash/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }} "></script>
    <!-- jQuery Sparkline -->
    <script src="{{ asset('dash/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }} "></script>
    <!-- Sweet Alert -->
    <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }} "></script>
    <!-- Bootstrap Notify -->
    <script src="{{ asset('dash/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }} "></script>

    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/b-flash-1.6.3/b-html5-1.6.3/b-print-1.6.3/r-2.2.5/datatables.min.js">
        </script>

    <script src="{{ asset('dash/js/atlantis.min.js') }}"></script>
    <script src="{{ asset('dash/js/atlantis.js') }}"></script>

    <script type="text/javascript"
        src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
        </script>

    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    <script src="{{ asset('dash/js/customs.js') }}"></script>
    @if ($isAdminShell)
        <script>
            if (window.lucide) {
                lucide.createIcons();
            }

            const firePremiumAdminAlert = (title, text, icon = 'info') => {
                if (!text || !window.Swal) {
                    return;
                }

                Swal.fire({
                    title,
                    text,
                    icon,
                    background: '#090b10',
                    color: '#e2e8f0',
                    backdrop: 'rgba(2, 6, 23, 0.82)',
                    confirmButtonColor: '#f0b90a',
                    customClass: {
                        popup: 'rounded-3xl border border-white/10',
                        confirmButton: 'rounded-xl font-black uppercase tracking-wider px-6 py-3'
                    }
                });
            };

            [
                { title: 'Success', text: @json(session('success')), icon: 'success' },
                { title: 'Error', text: @json(session('error')), icon: 'error' },
                { title: 'Notice', text: @json(session('message')), icon: 'warning' },
                { title: 'Information', text: @json(session('info')), icon: 'info' }
            ].forEach((alert) => firePremiumAdminAlert(alert.title, alert.text, alert.icon));
        </script>
    @endif
    @show

</body>

</html>
