@extends('layouts.dasht')
@section('title', 'Support')
@section('content')

    <div class="page-content-stack animate-fadeIn" x-data="{ isSubmitting: false }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Support Desk</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Support <span class="gold-text">Center</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Contact our support team for any help you need.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div
                    class="flex items-center px-4 py-2 rounded-xl bg-emerald-500/5 border border-emerald-500/10 text-emerald-400">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-2"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Support: Online</span>
                </div>
            </div>
        </div>

        <!-- Support Access Points -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8 border-white/5 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-500/5 blur-3xl group-hover:bg-yellow-500/10 transition-all">
                </div>
                <div class="h-12 w-12 rounded-xl bg-black border border-white/10 flex items-center justify-center mb-6">
                    <i data-lucide="mail" class="w-6 h-6 gold-text"></i>
                </div>
                <h3 class="text-sm font-black text-white uppercase tracking-wider mb-2">Email Support</h3>
                <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed mb-6">Best for formal or detailed
                    questions.</p>
                <a href="mailto:{{$settings->contact_email}}"
                    class="text-xs font-black gold-text hover:underline transition-all">
                    {{$settings->contact_email}}
                </a>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 border-white/5 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 blur-3xl group-hover:bg-blue-500/10 transition-all">
                </div>
                <div class="h-12 w-12 rounded-xl bg-black border border-white/10 flex items-center justify-center mb-6">
                    <i data-lucide="message-square" class="w-6 h-6 text-blue-400"></i>
                </div>
                <h3 class="text-sm font-black text-white uppercase tracking-wider mb-2">Live Chat</h3>
                <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed mb-6">Fastest way to get immediate
                    help.</p>
                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Live status:
                    Available</span>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 border-white/5 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 w-24 h-24 bg-purple-500/5 blur-3xl group-hover:bg-purple-500/10 transition-all">
                </div>
                <div class="h-12 w-12 rounded-xl bg-black border border-white/10 flex items-center justify-center mb-6">
                    <i data-lucide="file-text" class="w-6 h-6 text-purple-400"></i>
                </div>
                <h3 class="text-sm font-black text-white uppercase tracking-wider mb-2">FAQ</h3>
                <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed mb-6">Answers to common questions.
                </p>
                <a href="#"
                    class="text-xs font-black gold-text hover:underline transition-all uppercase tracking-widest">Read
                    FAQ</a>
            </div>
        </div>

        <!-- Communication Pipeline -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-10">
            <!-- Message Terminal -->
            <div class="lg:col-span-8">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 xl:p-10">
                    <div class="flex items-center space-x-3 mb-10">
                        <div class="h-px bg-white/10 flex-1"></div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">SEND A MESSAGE</span>
                        <div class="h-px bg-white/10 flex-1"></div>
                    </div>

                    <form method="post" action="{{route('enquiry')}}" @submit="isSubmitting = true" class="space-y-7 sm:space-y-8">
                        @csrf
                        <input type="hidden" name="name" value="{{Auth::user()->name}}" />
                        <input type="hidden" name="email" value="{{Auth::user()->email}}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 sm:gap-6">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Your
                                    Name</label>
                                <div
                                    class="w-full bg-white/[0.02] border border-white/5 rounded-xl px-5 py-4 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                    {{Auth::user()->name}}
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Your
                                    Email</label>
                                <div
                                    class="w-full bg-white/[0.02] border border-white/5 rounded-xl px-5 py-4 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                    {{Auth::user()->email}}
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Your
                                Message</label>
                            <textarea name="message" required
                                class="w-full bg-white/[0.02] border border-white/10 rounded-2xl p-6 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-600 min-h-[200px]"
                                placeholder="Type your message here..."></textarea>
                        </div>

                        <button type="submit" :disabled="isSubmitting"
                            class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-yellow-500/10 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3">
                            <span x-show="!isSubmitting">Send Message</span>
                            <span x-show="isSubmitting">Sending...</span>
                            <i data-lucide="send" class="w-5 h-5" x-show="!isSubmitting"></i>
                        </button>

                        <p class="text-center text-[9px] text-slate-500 font-bold uppercase tracking-widest">
                            Average Response Time: <span class="text-slate-300">4-8 Hours</span>
                        </p>
                    </form>
                </div>
            </div>

            <!-- System Intelligence -->
            <div class="lg:col-span-4 space-y-5 sm:space-y-6">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-500/[0.02] blur-3xl"></div>
                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-8 border-b border-white/5 pb-4">
                        Support Guidelines</h3>

                    <div class="space-y-6 sm:space-y-8">
                        <div class="flex items-start space-x-4">
                            <div
                                class="h-8 w-8 rounded-lg bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Account Recovery</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Identity verification is required for all account recovery requests.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="h-8 w-8 rounded-lg bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="info" class="w-4 h-4 text-blue-400"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Funding Assistance</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Include transaction IDs for all deposit-related questions.</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="h-8 w-8 rounded-lg bg-rose-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-400"></i>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Security Alerts</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Report suspicious account activity immediately so we can secure your account.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-yellow-500 to-amber-600 text-black">
                    <h3 class="text-xs font-black uppercase tracking-widest mb-4">VIP Support</h3>
                    <p class="text-[10px] font-black uppercase leading-relaxed mb-6 opacity-80">Clients with portfolios exceeding {{Auth::user()->currency}}100k get direct access to a dedicated account manager.</p>
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-full border-2 border-black/20 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(($settings->site_name ?? config('app.name')) . ' Elite') }}&background=000&color=f0b90a"
                                alt="Elite Support">
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest">Contact VIP Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endpush
