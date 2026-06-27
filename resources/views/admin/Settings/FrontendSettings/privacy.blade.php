<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.admin-dasht')
@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-slate-300">Frontend Content</span>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-white">Terms & <span class="gold-text">Privacy</span></h1>
            <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                Control whether policy content is active and update the legal copy displayed across the public website.
            </p>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Policy Status</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight {{ $terms->useterms == 'yes' ? 'text-emerald-400' : 'text-rose-300' }}">
                    {{ $terms->useterms == 'yes' ? 'Enabled' : 'Disabled' }}
                </h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Frontend legal pages visibility</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Editor</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">Rich Text</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">CKEditor-enabled content management</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Content Length</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format(strlen(strip_tags($terms->description ?? ''))) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Characters in the current policy copy</p>
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8">
            <form method="post" action="{{ route('savetermspolicy') }}" class="space-y-5">
                @csrf
                <div class="form-group">
                    <h5 class="">Use Terms and Privacy Policy?</h5>
                    <div class="selectgroup">
                        <label class="selectgroup-item">
                            <input type="radio" name="terms" id="termsyes" value="yes" class="selectgroup-input" checked="">
                            <span class="selectgroup-button">Yes</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="terms" id="termsno" value="no" class="selectgroup-input">
                            <span class="selectgroup-button">No</span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="ckeditor form-control" name="termsprivacy">{{ $terms->description }}</textarea>
                </div>
                <div class="form-group mb-0">
                    <input type="submit" class="px-5 btn btn-primary btn-lg" value="Save">
                </div>
            </form>
        </div>
        @if ($terms->useterms == 'yes')
            <script>
                document.getElementById("termsyes").checked = true;
            </script>
        @else
            <script>
                document.getElementById("termsno").checked = true;
            </script>
        @endif
    @endsection
    @section('scripts')
        @parent
        <script src="//cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.ckeditor').ckeditor();
            });
        </script>
    @endsection
