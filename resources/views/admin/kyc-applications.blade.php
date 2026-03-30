@extends('layouts.admin-dasht')

@section('content')
    @php
        $resolveProof = static function (?string $path): array {
            if (!$path) {
                return ['url' => null, 'kind' => 'missing', 'label' => 'No file uploaded'];
            }

            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $isRemote = str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
            $isPdf = $extension === 'pdf';
            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);

            if ($isRemote) {
                return [
                    'url' => $path,
                    'kind' => $isPdf ? 'pdf' : ($isImage ? 'image' : 'file'),
                    'label' => basename(parse_url($path, PHP_URL_PATH) ?: $path),
                ];
            }

            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                return [
                    'url' => \Illuminate\Support\Facades\Storage::disk('public')->url($path),
                    'kind' => $isPdf ? 'pdf' : ($isImage ? 'image' : 'file'),
                    'label' => basename($path),
                ];
            }

            return ['url' => null, 'kind' => 'missing', 'label' => basename($path)];
        };

        $frontProof = $resolveProof($kyc->frontimg);
        $backProof = $resolveProof($kyc->backimg);
        $faceProof = $resolveProof($kyc->face_img);
    @endphp
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <a href="{{ route('kyc') }}" class="transition-colors hover:text-yellow-500">KYC</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Application Review</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">{{ data_get($kyc, 'user.name', 'User') }} <span class="gold-text">KYC Review</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Review the applicant’s identity details, address information, and uploaded proof documents before accepting or rejecting verification.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('kyc') }}"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                    Back to Queue
                </a>
                <button type="button" data-toggle="modal" data-target="#action"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="shield-check" class="mr-2 h-4 w-4"></i>
                    Process KYC
                </button>
            </div>
        </div>

        <div id="action" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="mb-0 text-white">Process KYC</h3>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('processkyc') }}" method="post" class="space-y-4">
                            @csrf
                            <div class="form-group">
                                <select name="action" class="form-control" required>
                                    <option value="Accept">Accept and verify user</option>
                                    <option value="Reject">Reject and remain unverified</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea name="message" class="form-control" rows="6" required>This is to inform you that following the documents you submitted, your account has been verified. You can now enjoy all our services without restrictions.</textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" class="form-control" placeholder="Account verified successfully" required>
                            </div>
                            <input type="hidden" name="kyc_id" value="{{ $kyc->id }}">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Status</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight {{ $kyc->status === 'Verified' ? 'text-emerald-400' : 'gold-text' }}">{{ $kyc->status }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current review state</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Applicant Email</p>
                <h2 class="mt-4 text-lg font-black tracking-tight text-white">{{ $kyc->email }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Primary contact record</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Document Type</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $kyc->document_type }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Submitted proof category</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">
            <div class="dashboard-glass p-6 sm:p-8">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Personal Information</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Applicant identity and account metadata</p>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">First Name</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->first_name }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Last Name</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->last_name }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Phone</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->phone_number }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Date of Birth</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->dob }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">SSN / ID Number</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->ssn ?: 'Not provided' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4 md:col-span-2">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Social Media</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->social_media }}</p>
                    </div>
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Address Information</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Residential and nationality data submitted by the user</p>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4 md:col-span-2">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Address</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->address }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">City</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->city }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">State</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->state }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/5 bg-black/30 p-4 md:col-span-2">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Country</p>
                        <p class="mt-2 font-bold text-white">{{ $kyc->country }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8">
            <div class="border-b border-white/5 pb-5">
                <h2 class="text-lg font-black uppercase tracking-tight text-white">Document Proof</h2>
                <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Front, back, and selfie uploads used for verification</p>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="rounded-3xl border border-white/5 bg-black/30 p-5">
                    <p class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Front View</p>
                    @if ($frontProof['kind'] === 'image' && $frontProof['url'])
                        <img src="{{ $frontProof['url'] }}" alt="Front document image" class="w-full rounded-2xl border border-white/10 object-cover">
                    @elseif ($frontProof['kind'] === 'pdf' && $frontProof['url'])
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center">
                            <p class="text-sm font-semibold text-white">Front document uploaded as PDF</p>
                            <a href="{{ $frontProof['url'] }}" target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center rounded-xl border border-yellow-400/30 bg-yellow-400/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-yellow-300 transition hover:bg-yellow-400/20">
                                Open PDF
                            </a>
                        </div>
                    @elseif ($frontProof['url'])
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center">
                            <p class="text-sm font-semibold text-white">{{ $frontProof['label'] }}</p>
                            <a href="{{ $frontProof['url'] }}" target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
                                Open File
                            </a>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center text-sm font-semibold text-slate-400">
                            Front proof not available
                        </div>
                    @endif
                </div>
                <div class="rounded-3xl border border-white/5 bg-black/30 p-5">
                    <p class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Back View</p>
                    @if ($backProof['kind'] === 'image' && $backProof['url'])
                        <img src="{{ $backProof['url'] }}" alt="Back document image" class="w-full rounded-2xl border border-white/10 object-cover">
                    @elseif ($backProof['kind'] === 'pdf' && $backProof['url'])
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center">
                            <p class="text-sm font-semibold text-white">Back document uploaded as PDF</p>
                            <a href="{{ $backProof['url'] }}" target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center rounded-xl border border-yellow-400/30 bg-yellow-400/10 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-yellow-300 transition hover:bg-yellow-400/20">
                                Open PDF
                            </a>
                        </div>
                    @elseif ($backProof['url'])
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center">
                            <p class="text-sm font-semibold text-white">{{ $backProof['label'] }}</p>
                            <a href="{{ $backProof['url'] }}" target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
                                Open File
                            </a>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center text-sm font-semibold text-slate-400">
                            Back proof not available
                        </div>
                    @endif
                </div>
                <div class="rounded-3xl border border-white/5 bg-black/30 p-5">
                    <p class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-500">Selfie / Face Match</p>
                    @if ($faceProof['kind'] === 'image' && $faceProof['url'])
                        <img src="{{ $faceProof['url'] }}" alt="Face verification image" class="w-full rounded-2xl border border-white/10 object-cover">
                    @elseif ($faceProof['url'])
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center">
                            <p class="text-sm font-semibold text-white">{{ $faceProof['label'] }}</p>
                            <a href="{{ $faceProof['url'] }}" target="_blank" rel="noopener"
                                class="mt-4 inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
                                Open File
                            </a>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-white/10 bg-slate-950/60 p-6 text-center text-sm font-semibold text-slate-400">
                            Face image not available
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
