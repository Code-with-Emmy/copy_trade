@extends('layouts.admin-dasht')

@section('title', 'Admin Security')

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="mx-auto" style="max-width: 1040px;">
                <div class="mb-4 rounded-4 border border-white/10 p-4 p-md-5" style="background: radial-gradient(circle at top right, rgba(240, 185, 10, 0.14), transparent 28%), linear-gradient(135deg, rgba(10,17,28,0.98), rgba(15,23,42,0.96)); box-shadow: 0 28px 60px -38px rgba(15, 23, 42, 0.95);">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-4">
                        <div>
                            <span class="d-inline-flex align-items-center px-3 py-2 rounded-pill mb-3" style="background: rgba(240, 185, 10, 0.12); border: 1px solid rgba(240, 185, 10, 0.18); color: #f0b90a; font-size: .72rem; font-weight: 800; letter-spacing: .16em; text-transform: uppercase;">
                                Admin Security
                            </span>
                            <h1 class="mb-2 text-white" style="font-size: clamp(2rem, 3vw, 2.8rem); font-weight: 800;">Change your password</h1>
                            <p class="mb-0" style="max-width: 620px; color: #94a3b8; font-size: 1rem; line-height: 1.7;">
                                Protect the control layer of the platform with a strong new credential. This update applies immediately to your admin session.
                            </p>
                        </div>
                        <div class="rounded-4 px-4 py-3" style="min-width: 240px; border: 1px solid rgba(148, 163, 184, 0.12); background: rgba(255,255,255,0.04);">
                            <div class="text-uppercase mb-2" style="font-size: .7rem; font-weight: 800; letter-spacing: .16em; color: #64748b;">Security posture</div>
                            <div class="d-flex align-items-center text-white" style="font-weight: 700;">
                                <span class="mr-2 d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 10px; height: 10px; background: #10b981;"></span>
                                Manual password rotation available
                            </div>
                        </div>
                    </div>
                </div>

                <x-danger-alert />
                <x-success-alert />

                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="rounded-4 border border-white/10 p-4 p-md-5 h-100" style="background: linear-gradient(180deg, rgba(15,23,42,0.96), rgba(9,14,24,0.98)); box-shadow: 0 24px 48px -36px rgba(2, 6, 23, 0.95);">
                            <div class="mb-4">
                                <h2 class="mb-2 text-white" style="font-size: 1.35rem; font-weight: 800;">Credential update</h2>
                                <p class="mb-0" style="color: #94a3b8;">Use a unique password with at least 8 characters and a number. Avoid reusing investor-side credentials.</p>
                            </div>

                            <form method="POST" action="{{ route('adminupdatepass') }}" class="d-grid" style="gap: 1.25rem;">
                                @csrf
                                <input type="hidden" name="id" value="{{ Auth('admin')->user()->id }}">
                                <input type="hidden" name="current_password" value="{{ Auth('admin')->user()->password }}">

                                <div>
                                    <label for="old_password" class="mb-2 d-block" style="color: #e2e8f0; font-size: .78rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase;">Current password</label>
                                    <input id="old_password" type="password" name="old_password" class="form-control border-0 rounded-4 px-4 py-3" style="background: rgba(15, 23, 42, 0.72); color: #fff; box-shadow: inset 0 0 0 1px rgba(148,163,184,.12);" required>
                                </div>

                                <div>
                                    <label for="password" class="mb-2 d-block" style="color: #e2e8f0; font-size: .78rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase;">New password</label>
                                    <input id="password" type="password" name="password" class="form-control border-0 rounded-4 px-4 py-3" style="background: rgba(15, 23, 42, 0.72); color: #fff; box-shadow: inset 0 0 0 1px rgba(148,163,184,.12);" required>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="mb-2 d-block" style="color: #e2e8f0; font-size: .78rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase;">Confirm password</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control border-0 rounded-4 px-4 py-3" style="background: rgba(15, 23, 42, 0.72); color: #fff; box-shadow: inset 0 0 0 1px rgba(148,163,184,.12);" required>
                                </div>

                                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pt-2">
                                    <div style="color: #64748b; font-size: .85rem;">
                                        Update takes effect immediately after successful validation.
                                    </div>
                                    <button type="submit" class="btn rounded-pill px-4 py-3" style="background: linear-gradient(135deg, #f0b90a, #d97706); color: #0f172a; font-weight: 800; letter-spacing: .08em; text-transform: uppercase;">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-xl-4 mt-4 mt-xl-0">
                        <div class="rounded-4 border border-white/10 p-4 p-md-5 h-100" style="background: rgba(15, 23, 42, 0.92); box-shadow: 0 20px 40px -34px rgba(2, 6, 23, 0.95);">
                            <div class="mb-4 text-white" style="font-size: 1.1rem; font-weight: 800;">Operational guidance</div>
                            <div class="d-grid" style="gap: 1rem;">
                                <div class="rounded-4 p-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(148,163,184,.12);">
                                    <div class="mb-2" style="color: #f8fafc; font-weight: 700;">Use a dedicated admin secret</div>
                                    <div style="color: #94a3b8; font-size: .92rem; line-height: 1.6;">Keep the admin credential separate from trader, investor, and infrastructure accounts.</div>
                                </div>
                                <div class="rounded-4 p-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(148,163,184,.12);">
                                    <div class="mb-2" style="color: #f8fafc; font-weight: 700;">Rotate after operational changes</div>
                                    <div style="color: #94a3b8; font-size: .92rem; line-height: 1.6;">Change this password after staff changes, shared device usage, or any suspicious login event.</div>
                                </div>
                                <div class="rounded-4 p-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(148,163,184,.12);">
                                    <div class="mb-2" style="color: #f8fafc; font-weight: 700;">Log every recovery event</div>
                                    <div style="color: #94a3b8; font-size: .92rem; line-height: 1.6;">Admin password changes should be treated as a privileged action and monitored as part of platform operations.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
