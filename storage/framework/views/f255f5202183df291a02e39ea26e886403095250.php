<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make('partials.theme-init', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? trim($__env->yieldContent('title')) ?: 'Admin Dashboard'); ?> | <?php echo e($settings->site_name); ?></title>

    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dashboard-theme.css')); ?>">
    <link rel="icon" href="<?php echo e(asset('storage/' . $settings->favicon)); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('dash/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dash/css/fonts.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dash/css/customs.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dash/css/style.css')); ?>">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo e(asset('dash/js/core/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dash/js/core/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dash/js/plugin/bootstrap-notify/bootstrap-notify.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <style>
        body {
            background-color: var(--dash-bg);
            font-family: 'Inter', -apple-system, sans-serif;
            color: var(--dash-text);
            overflow-x: hidden;
        }

        a,
        a:hover,
        a:focus,
        a:active {
            text-decoration: none;
        }

        .dashboard-glass {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 2px;
            box-shadow: 0 24px 60px -46px rgba(0, 0, 0, 0.9);
        }

        .gold-text {
            color: var(--accent-gold);
        }

        .gold-gradient-bg {
            background: linear-gradient(135deg, #f0b90a, #d4a017);
        }

        .sidebar-link {
            display: grid;
            grid-template-columns: 2.2rem minmax(0, 1fr);
            align-items: center;
            column-gap: 0.75rem;
            width: 100%;
            min-height: 2.3rem;
            padding: 0.35rem 0.75rem;
            margin: 0.08rem 0;
            border-radius: 12px;
            color: var(--dash-text-muted);
            transition: all 0.2s ease;
            font-size: 0.875rem;
            line-height: 1.25rem;
            position: relative;
        }

        .sidebar-link:hover {
            background: var(--dash-bg-hover);
            color: var(--dash-text);
        }

        .sidebar-link.active {
            background: rgba(240, 185, 10, 0.1);
            color: var(--accent-gold);
            box-shadow: inset 0 0 0 1px rgba(240, 185, 10, 0.08);
        }

        .sidebar-link i {
            width: 10rem;
            height: 2rem;
            opacity: 0.9;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.03);
            padding: 0.45rem;
            transition: all 0.2s ease;
        }

        .sidebar-link span {
            min-width: 0;
            display: block;
            font-size: 0.81rem;
            font-weight: 800;
            letter-spacing: 0.01em;
            line-height: 1.25rem;
        }

        .sidebar-link:hover i {
            border-color: rgba(240, 185, 10, 0.14);
            background: rgba(240, 185, 10, 0.05);
        }

        .sidebar-link.active i {
            color: #f0b90a;
            border-color: rgba(240, 185, 10, 0.18);
            background: rgba(240, 185, 10, 0.08);
        }

        .sidebar-section-label {
            margin: 0.85rem 0 0.4rem;
            padding: 0 0.75rem;
            font-size: 0.625rem;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--dash-text-faint);
        }

        .top-nav {
            background: var(--dash-nav-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--dash-border-subtle);
            height: 70px;
        }

        html.dark .border-white\/5,
        html.dark .border-white\/10 {
            border-color: rgba(240, 185, 10, 0.04) !important;
        }

        html.dark .border-b.border-white\/5,
        html.dark .border-t.border-white\/5,
        html.dark .border-b.border-white\/10,
        html.dark .border-t.border-white\/10 {
            border-color: rgba(240, 185, 10, 0.04) !important;
        }

        .page-shell {
            width: 100%;
            max-width: 1520px;
            margin: 0 auto;
        }

        .page-content-stack {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .page-shell .main-panel,
        .page-shell .content,
        .page-shell .page-inner,
        .page-shell .container-fluid {
            width: 100%;
            max-width: none;
            margin: 0;
            padding: 0;
            background: transparent;
            float: none;
            position: static;
            inset: auto;
            min-height: 0;
        }

        .page-shell .page-inner {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .page-shell .legacy-panel-stack {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .page-shell .legacy-hero-card {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.5rem 1.65rem;
            border: 1px solid rgba(240, 185, 10, 0.06);
            border-radius: 24px;
            background:
                radial-gradient(circle at top right, rgba(240, 185, 10, 0.12), transparent 32%),
                linear-gradient(135deg, rgba(8, 11, 18, 0.96), rgba(15, 23, 42, 0.92));
            box-shadow: 0 28px 60px -42px rgba(0, 0, 0, 0.95);
        }

        .page-shell .legacy-hero-card .eyebrow {
            color: #64748b;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.68rem;
            font-weight: 900;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .page-shell .legacy-hero-card .subtitle {
            max-width: 760px;
            margin: 0.75rem 0 0;
            color: #94a3b8;
            line-height: 1.7;
        }

        .page-shell .legacy-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .page-shell .legacy-stat-card {
            padding: 1.25rem 1.3rem;
            border: 1px solid rgba(240, 185, 10, 0.05);
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.03);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.02);
        }

        .page-shell .legacy-stat-card .eyebrow {
            color: #64748b;
            font-size: 0.62rem;
            font-weight: 900;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .page-shell .legacy-stat-card .value {
            margin-top: 0.85rem;
            color: #fff;
            font-size: 1.65rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1;
        }

        .page-shell .legacy-stat-card .meta {
            margin-top: 0.55rem;
            color: #94a3b8;
            font-size: 0.78rem;
        }

        .page-shell .page-inner > .mt-2,
        .page-shell .page-inner > .mt-2.mb-4,
        .page-shell .page-inner > .mt-2.mb-5,
        .page-shell .page-inner > .mt-2.mb-3,
        .page-shell .page-inner > .my-2.mb-4,
        .page-shell .page-inner > .mb-4 {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.5rem 1.65rem;
            margin: 0 !important;
            border: 1px solid rgba(240, 185, 10, 0.06);
            border-radius: 24px;
            background:
                radial-gradient(circle at top right, rgba(240, 185, 10, 0.12), transparent 32%),
                linear-gradient(135deg, rgba(8, 11, 18, 0.96), rgba(15, 23, 42, 0.92));
            box-shadow: 0 28px 60px -42px rgba(0, 0, 0, 0.95);
        }

        .page-shell .page-inner > .mt-2 br,
        .page-shell .page-inner > .mt-2.mb-4 br,
        .page-shell .page-inner > .mt-2.mb-5 br,
        .page-shell .page-inner > .mt-2.mb-3 br,
        .page-shell .page-inner > .my-2.mb-4 br,
        .page-shell .page-inner > .mb-4 br {
            display: none;
        }

        .page-shell .page-inner > .mt-2 > p,
        .page-shell .page-inner > .mt-2.mb-4 > p,
        .page-shell .page-inner > .mt-2.mb-5 > p,
        .page-shell .page-inner > .mt-2.mb-3 > p,
        .page-shell .page-inner > .my-2.mb-4 > p,
        .page-shell .page-inner > .mb-4 > p,
        .page-shell .page-inner > .mt-2 .text-muted,
        .page-shell .page-inner > .mt-2.mb-4 .text-muted,
        .page-shell .page-inner > .mt-2.mb-5 .text-muted,
        .page-shell .page-inner > .mt-2.mb-3 .text-muted,
        .page-shell .page-inner > .my-2.mb-4 .text-muted,
        .page-shell .page-inner > .mb-4 .text-muted {
            max-width: 720px;
            margin: 0.65rem 0 0 !important;
            color: #94a3b8 !important;
            line-height: 1.65;
        }

        .page-shell .page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.5rem 1.65rem;
            margin: 0 !important;
            border: 1px solid rgba(240, 185, 10, 0.06);
            border-radius: 24px;
            background:
                radial-gradient(circle at top right, rgba(240, 185, 10, 0.12), transparent 32%),
                linear-gradient(135deg, rgba(8, 11, 18, 0.96), rgba(15, 23, 42, 0.92));
            box-shadow: 0 28px 60px -42px rgba(0, 0, 0, 0.95);
        }

        .page-shell .page-header .page-title {
            margin-bottom: 0.35rem;
        }

        .page-shell .breadcrumbs {
            margin-bottom: 0;
            background: transparent;
        }

        .page-shell .breadcrumbs li,
        .page-shell .breadcrumbs a {
            color: #94a3b8 !important;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .page-shell .breadcrumbs .separator {
            opacity: 0.45;
        }

        .page-shell .page-inner > .row,
        .page-shell .page-inner > .mb-5.row,
        .page-shell .page-inner > .row.mb-5 {
            margin: 0;
            row-gap: 1.25rem;
        }

        .page-shell .page-inner > .row > [class*="col-"],
        .page-shell .page-inner > .mb-5.row > [class*="col-"],
        .page-shell .page-inner > .row.mb-5 > [class*="col-"] {
            padding-left: 0.65rem;
            padding-right: 0.65rem;
        }

        .page-shell .tab-content > .tab-pane > .row,
        .page-shell .tab-content > .tab-pane > .form-row,
        .page-shell .tab-content > .tab-pane > form,
        .page-shell .tab-content > .tab-pane > .table-responsive {
            margin: 0;
            padding: 1.5rem 1.65rem;
            border: 1px solid rgba(240, 185, 10, 0.05);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.03);
            box-shadow: 0 24px 60px -46px rgba(0, 0, 0, 0.9);
        }

        .page-shell .tab-content > .tab-pane > .row + .row,
        .page-shell .tab-content > .tab-pane > .form-row + .form-row,
        .page-shell .tab-content > .tab-pane > form + form,
        .page-shell .tab-content > .tab-pane > .table-responsive + .table-responsive {
            margin-top: 1.25rem;
        }

        .page-shell .tab-content > .tab-pane > .row > [class*="col-"],
        .page-shell .tab-content > .tab-pane > .form-row > [class*="col-"] {
            padding-left: 0.65rem;
            padding-right: 0.65rem;
        }

        .page-shell .tab-content > .tab-pane > .row > [class*="col-"] > h4,
        .page-shell .tab-content > .tab-pane > .row > [class*="col-"] > h5,
        .page-shell .tab-content > .tab-pane > .form-row > [class*="col-"] > h4,
        .page-shell .tab-content > .tab-pane > .form-row > [class*="col-"] > h5 {
            margin-bottom: 0.15rem;
            color: #fff;
            font-size: 1.05rem;
            font-weight: 900;
            letter-spacing: -0.02em;
            text-transform: none;
        }

        .page-shell .title1,
        .page-shell h1.h3,
        .page-shell .page-title {
            color: #fff;
            font-size: clamp(1.75rem, 2vw, 2.4rem);
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1.05;
            margin: 0;
        }

        .page-shell .card,
        .page-shell .modal-content {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(240, 185, 10, 0.05);
            border-radius: 22px;
            box-shadow: 0 24px 60px -46px rgba(0, 0, 0, 0.9);
            color: #e2e8f0;
        }

        .page-shell .card-header,
        .page-shell .modal-header,
        .page-shell .card-footer,
        .page-shell .modal-footer {
            background: rgba(255, 255, 255, 0.02);
            border-color: rgba(240, 185, 10, 0.05);
        }

        .page-shell .card-body,
        .page-shell .modal-body {
            color: #cbd5e1;
        }

        .page-shell .card-title,
        .page-shell .card h1,
        .page-shell .card h2,
        .page-shell .card h3,
        .page-shell .card h4,
        .page-shell .card h5,
        .page-shell .card h6,
        .page-shell .modal-title {
            color: #fff;
        }

        .page-shell .card-round {
            border-radius: 22px !important;
        }

        .page-shell .card-profile .card-header {
            min-height: 140px;
            background-size: cover;
            background-position: center;
        }

        .page-shell .profile-picture {
            margin-top: 2rem;
        }

        .page-shell .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .page-shell .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .page-shell .user-profile .name,
        .page-shell .user-profile .job,
        .page-shell .user-profile .desc,
        .page-shell .card-category {
            color: #cbd5e1;
        }

        .page-shell .user-profile .name {
            color: #fff;
            font-weight: 900;
        }

        .page-shell .number {
            color: #fff;
            font-weight: 900;
        }

        .page-shell .border,
        .page-shell .table-bordered th,
        .page-shell .table-bordered td,
        .page-shell .table td,
        .page-shell .table th,
        .page-shell hr {
            border-color: rgba(240, 185, 10, 0.05) !important;
        }

        .page-shell .table {
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .page-shell .table thead th {
            color: #94a3b8;
            background: rgba(255, 255, 255, 0.02);
            font-size: 0.65rem;
            font-weight: 900;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            border-bottom-width: 1px;
        }

        .page-shell .table-hover tbody tr:hover,
        .page-shell .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .page-shell .table-responsive {
            border-radius: 18px;
        }

        .page-shell .form-control,
        .page-shell .custom-select,
        .page-shell select,
        .page-shell textarea,
        .page-shell input[type="text"],
        .page-shell input[type="email"],
        .page-shell input[type="number"],
        .page-shell input[type="password"],
        .page-shell input[type="date"],
        .page-shell input[type="time"] {
            min-height: 50px;
            border-radius: 16px;
            border: 1px solid rgba(240, 185, 10, 0.08);
            background: rgba(0, 0, 0, 0.28);
            color: #fff;
            box-shadow: none;
        }

        .page-shell textarea.form-control,
        .page-shell textarea {
            min-height: 120px;
        }

        .page-shell .form-control:focus,
        .page-shell .custom-select:focus,
        .page-shell select:focus,
        .page-shell textarea:focus,
        .page-shell input:focus {
            border-color: rgba(240, 185, 10, 0.35);
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(240, 185, 10, 0.08);
        }

        .page-shell .form-control::placeholder,
        .page-shell textarea::placeholder,
        .page-shell input::placeholder {
            color: #64748b;
        }

        .page-shell label,
        .page-shell .form-group > h4,
        .page-shell .form-group > h5,
        .page-shell .form-group > h6 {
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 900;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 0.7rem;
        }

        .page-shell .nav-tabs,
        .page-shell .nav-pills {
            gap: 0.75rem;
            border: 0;
        }

        .page-shell .nav-tabs .nav-link,
        .page-shell .nav-pills .nav-link {
            border: 1px solid rgba(240, 185, 10, 0.08);
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.02);
            color: #94a3b8;
            font-size: 0.68rem;
            font-weight: 900;
            letter-spacing: 0.18em;
            padding: 0.85rem 1.25rem;
            text-transform: uppercase;
        }

        .page-shell .nav-tabs .nav-link.active,
        .page-shell .nav-pills .nav-link.active,
        .page-shell .nav-tabs .show > .nav-link,
        .page-shell .nav-pills .show > .nav-link {
            background: linear-gradient(135deg, #f0b90a, #d4a017);
            border-color: transparent;
            color: #050505;
        }

        .page-shell .btn {
            border-radius: 14px;
            font-size: 0.72rem;
            font-weight: 900;
            letter-spacing: 0.14em;
            padding: 0.85rem 1.3rem;
            text-transform: uppercase;
        }

        .page-shell .btn-primary,
        .page-shell .btn-info {
            background: linear-gradient(135deg, #f0b90a, #d4a017);
            border-color: transparent;
            color: #050505;
        }

        .page-shell .btn-primary:hover,
        .page-shell .btn-info:hover {
            color: #050505;
            filter: brightness(1.04);
        }

        .page-shell .btn-secondary,
        .page-shell .btn-light,
        .page-shell .btn-default,
        .page-shell .btn-outline-light,
        .page-shell .btn-outline-primary {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(240, 185, 10, 0.08);
            color: #e2e8f0;
        }

        .page-shell .btn-danger {
            background: rgba(225, 29, 72, 0.14);
            border-color: rgba(225, 29, 72, 0.26);
            color: #fecdd3;
        }

        .page-shell .btn-warning {
            background: rgba(250, 204, 21, 0.14);
            border-color: rgba(250, 204, 21, 0.2);
            color: #fde68a;
        }

        .page-shell .btn-success {
            background: rgba(16, 185, 129, 0.14);
            border-color: rgba(16, 185, 129, 0.2);
            color: #bbf7d0;
        }

        .page-shell .alert {
            border-radius: 18px;
            border-width: 1px;
        }

        .page-shell .alert-danger {
            background: rgba(225, 29, 72, 0.12);
            border-color: rgba(225, 29, 72, 0.18);
            color: #fecdd3;
        }

        .page-shell .alert-success {
            background: rgba(16, 185, 129, 0.12);
            border-color: rgba(16, 185, 129, 0.18);
            color: #bbf7d0;
        }

        .page-shell .alert-info {
            background: rgba(59, 130, 246, 0.12);
            border-color: rgba(59, 130, 246, 0.18);
            color: #bfdbfe;
        }

        .page-shell .badge {
            border-radius: 9999px;
            padding: 0.5rem 0.85rem;
            font-size: 0.6rem;
            font-weight: 900;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .page-shell .badge-warning {
            background: rgba(250, 204, 21, 0.14);
            color: #fde68a;
        }

        .page-shell .badge-success {
            background: rgba(16, 185, 129, 0.14);
            color: #bbf7d0;
        }

        .page-shell .badge-danger {
            background: rgba(225, 29, 72, 0.14);
            color: #fecdd3;
        }

        .page-shell .badge-info {
            background: rgba(59, 130, 246, 0.14);
            color: #bfdbfe;
        }

        .page-shell .badge-secondary {
            background: rgba(148, 163, 184, 0.16);
            color: #e2e8f0;
        }

        .page-shell .dropdown-menu {
            background: rgba(6, 10, 18, 0.96);
            border: 1px solid rgba(240, 185, 10, 0.08);
            border-radius: 18px;
            box-shadow: 0 24px 60px -40px rgba(0, 0, 0, 0.9);
            padding: 0.75rem;
        }

        .page-shell .dropdown-item {
            border-radius: 12px;
            color: #cbd5e1;
            font-size: 0.78rem;
            padding: 0.7rem 0.9rem;
        }

        .page-shell .dropdown-item:hover,
        .page-shell .dropdown-item:focus {
            background: rgba(255, 255, 255, 0.04);
            color: #fff;
        }

        .page-shell .selectgroup-button {
            border-radius: 9999px !important;
            border-color: rgba(240, 185, 10, 0.08) !important;
            background: rgba(255, 255, 255, 0.02);
            color: #cbd5e1;
        }

        .page-shell .selectgroup-input:checked + .selectgroup-button {
            background: linear-gradient(135deg, #f0b90a, #d4a017);
            border-color: transparent !important;
            color: #050505;
        }

        .page-shell .help-block,
        .page-shell .text-danger {
            color: #fca5a5 !important;
        }

        .page-shell .text-info {
            color: #7dd3fc !important;
        }

        .page-shell .text-success {
            color: #86efac !important;
        }

        .page-shell .text-warning {
            color: #fde68a !important;
        }

        .page-shell .text-primary {
            color: #f0b90a !important;
        }

        .page-shell .bg-light {
            background: rgba(255, 255, 255, 0.04) !important;
            color: #e2e8f0 !important;
        }

        .page-shell .text-gray-800,
        .page-shell .text-dark {
            color: #fff !important;
        }

        .page-shell .close {
            color: #fff;
            text-shadow: none;
            opacity: 0.7;
        }

        .page-shell .close:hover {
            opacity: 1;
        }

        .page-shell .select2-container {
            width: 100% !important;
        }

        .page-shell .select2-container--default .select2-selection--single,
        .page-shell .select2-container--default .select2-selection--multiple {
            min-height: 50px !important;
            border-radius: 16px !important;
            border: 1px solid rgba(240, 185, 10, 0.08) !important;
            background: rgba(0, 0, 0, 0.28) !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        .page-shell .select2-container--default .select2-selection--single .select2-selection__rendered,
        .page-shell .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            color: #fff !important;
            line-height: 48px !important;
            padding-left: 14px !important;
        }

        .page-shell .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px !important;
        }

        .page-shell .dataTables_wrapper .dataTables_info,
        .page-shell .dataTables_wrapper .dataTables_paginate,
        .page-shell .dataTables_wrapper .dataTables_length,
        .page-shell .dataTables_wrapper .dataTables_filter {
            color: #94a3b8 !important;
            padding-top: 1rem;
        }

        .page-shell .dataTables_wrapper .dataTables_filter input,
        .page-shell .dataTables_wrapper .dataTables_length select {
            background: rgba(0, 0, 0, 0.3);
            color: #fff;
            border: 1px solid rgba(240, 185, 10, 0.08);
            border-radius: 14px;
            min-height: 42px;
            padding: 0.55rem 0.85rem;
        }

        .page-shell .dt-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.55rem;
            margin-bottom: 1rem;
        }

        .page-shell .dt-button {
            border: 1px solid rgba(240, 185, 10, 0.08) !important;
            border-radius: 999px !important;
            background: rgba(255, 255, 255, 0.04) !important;
            color: #fff !important;
            padding: 0.72rem 1rem !important;
            font-weight: 800 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase;
            box-shadow: none !important;
        }

        .page-shell .dt-button:hover {
            background: rgba(255, 255, 255, 0.08) !important;
            color: #fff !important;
        }

        .page-shell .pagination {
            gap: 0.35rem;
        }

        .page-shell .page-item .page-link {
            border-radius: 999px;
            border: 1px solid rgba(240, 185, 10, 0.08);
            background: rgba(255, 255, 255, 0.03);
            color: #cbd5e1;
        }

        .page-shell .page-item.active .page-link {
            background: linear-gradient(135deg, #f0b90a, #d4a017);
            border-color: transparent;
            color: #050505;
        }

        .page-shell .list-group-item {
            background: rgba(255, 255, 255, 0.03);
            color: #cbd5e1;
            border-color: rgba(240, 185, 10, 0.05);
        }

        .page-shell .table-typo td:first-child {
            width: 44%;
            color: #94a3b8;
            font-weight: 800;
        }

        .page-shell .table-typo td strong {
            color: inherit;
            font-weight: inherit;
        }

        .page-shell .card-stats {
            overflow: hidden;
        }

        .page-shell .card-stats .card-body {
            padding: 1.25rem;
        }

        .page-shell .icon-big {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: rgba(240, 185, 10, 0.12);
            color: #f0b90a;
            font-size: 1.15rem;
        }

        .page-shell .icon-big.icon-info {
            background: rgba(59, 130, 246, 0.14);
            color: #93c5fd;
        }

        .page-shell .icon-big.icon-success {
            background: rgba(16, 185, 129, 0.14);
            color: #86efac;
        }

        .page-shell .icon-big.icon-secondary {
            background: rgba(148, 163, 184, 0.14);
            color: #cbd5e1;
        }

        .page-shell .numbers {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .page-shell .social-media {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.7rem;
            margin-top: 1.25rem;
        }

        .page-shell .social-media .btn {
            min-width: 46px;
            padding: 0.75rem 0.9rem;
        }

        .page-shell small,
        .page-shell .small {
            color: #94a3b8 !important;
        }

        @media (min-width: 1024px) {
            .page-content-stack {
                gap: 2.5rem;
            }
        }

        @media (max-width: 991.98px) {
            .page-shell .page-inner > .row > [class*="col-"],
            .page-shell .page-inner > .mb-5.row > [class*="col-"],
            .page-shell .page-inner > .row.mb-5 > [class*="col-"] {
                padding-left: 0;
                padding-right: 0;
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #000;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }

        [x-cloak] {
            display: none !important;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(10px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease-out forwards;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
    <?php echo $__env->yieldPushContent('head'); ?>
</head>

<body class="antialiased" x-data="{ sidebarOpen: false, fabOpen: false }">
    <?php
        $unreadNotifications = $unreadNotifications ?? collect();
        $notifications = $notifications ?? collect();
        $count = $count ?? (is_countable($unreadNotifications) ? count($unreadNotifications) : 0);
    ?>
    <?php echo $__env->make('admin.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="lg:ml-80 flex flex-col min-h-screen">
        <?php echo $__env->make('admin.topmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <main class="flex-1 p-4 sm:p-6 lg:p-10 pb-32 lg:pb-10">
            <div class="page-shell">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>

        <footer class="hidden lg:flex p-10 border-t border-white/5 text-slate-500 text-[11px] tracking-wide font-medium items-center justify-between">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($settings->site_name); ?>. Admin operations console.</p>
            <div class="flex items-center space-x-8">
                <a href="<?php echo e(route('admin.profile')); ?>" class="hover:text-white transition-colors uppercase">Profile</a>
                <a href="<?php echo e(route('admin.settings.payments')); ?>" class="hover:text-white transition-colors uppercase">Payments</a>
                <div class="flex items-center">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                    Admin Status: Operational
                </div>
            </div>
        </footer>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    <?php echo $__env->yieldContent('scripts'); ?>
    <script src="<?php echo e(asset('theme-toggle.js')); ?>"></script>
    <script>
        lucide.createIcons();

        const getSwalTheme = () => {
            const isLight = document.documentElement.classList.contains('light');
            return {
                background: isLight ? '#ffffff' : '#090b10',
                color: isLight ? '#0f172a' : '#e2e8f0',
                backdrop: isLight ? 'rgba(15,23,42,0.35)' : 'rgba(2,6,23,0.8)',
            };
        };

        const firePremiumAlert = (title, text, icon = 'info') => {
            if (!text) return;
            const theme = getSwalTheme();
            Swal.fire({
                title,
                text,
                icon,
                background: theme.background,
                color: theme.color,
                backdrop: theme.backdrop,
                confirmButtonColor: '#f0b90a',
                customClass: {
                    popup: 'rounded-3xl border border-white/10',
                    confirmButton: 'rounded-xl font-black uppercase tracking-wider px-6 py-3'
                }
            });
        };

        const flashAlerts = [
            { key: 'success', title: 'Success', text: <?php echo json_encode(session('success'), 15, 512) ?>, icon: 'success' },
            { key: 'error', title: 'Error', text: <?php echo json_encode(session('error'), 15, 512) ?>, icon: 'error' },
            { key: 'message', title: 'Notice', text: <?php echo json_encode(session('message'), 15, 512) ?>, icon: 'warning' },
            { key: 'info', title: 'Information', text: <?php echo json_encode(session('info'), 15, 512) ?>, icon: 'info' }
        ];

        flashAlerts.forEach((alert) => firePremiumAlert(alert.title, alert.text, alert.icon));
    </script>
</body>

</html>
<?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/layouts/admin-dasht.blade.php ENDPATH**/ ?>