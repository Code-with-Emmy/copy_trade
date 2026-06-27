@inject('uc', 'App\Http\Controllers\User\UsersController')
@php
    $array = \App\Models\User::all();
    $usr = Auth::user()->id;
@endphp
@extends('layouts.dasht')
@section('title', 'Referral')
@section('content')

    <div class="space-y-10 animate-fadeIn" x-data="{ 
                    showCopied: false, 
                    selectedTab: 'overview',
                    showShareModal: false
                 }">

        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Referral Program</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Invite <span class="gold-text">Friends</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Invite your friends and earn rewards when they join.</p>
            </div>

            <div class="flex items-center space-x-3">
                <button @click="showShareModal = true"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="share-2" class="w-4 h-4 mr-2"></i>
                    Share Link
                </button>
            </div>
        </div>

        <!-- Network Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-24 bg-yellow-500/[0.03] blur-2xl"></div>
                <h4 class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-4">Friends Invited</h4>
                <div class="text-3xl font-black text-white tracking-tighter">
                    {{ count($array->where('ref_by', Auth::user()->id)) }}
                </div>
                <div class="mt-4 flex items-center text-[9px] font-black text-emerald-500 uppercase tracking-tighter">
                    <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                    +1 New Friend
                </div>
            </div>

            <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-24 bg-emerald-500/[0.03] blur-2xl"></div>
                <h4 class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-4">Total Rewards</h4>
                <div class="text-3xl font-black text-emerald-400 tracking-tighter">
                    {{ Auth::user()->currency }}{{ number_format(Auth::user()->ref_earnings ?? 0, 2) }}
                </div>
                <div class="mt-4 flex items-center text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                    Earned so far
                </div>
            </div>

            <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-24 bg-purple-500/[0.03] blur-2xl"></div>
                <h4 class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-4">Your Level</h4>
                <div class="text-lg font-black gold-text tracking-tighter uppercase">
                    @php
                        $referralCount = count($array->where('ref_by', Auth::user()->id));
                        if ($referralCount >= 100)
                            echo 'ELITE LEVEL';
                        elseif ($referralCount >= 50)
                            echo 'GOLD LEVEL';
                        elseif ($referralCount >= 25)
                            echo 'SILVER LEVEL';
                        elseif ($referralCount >= 10)
                            echo 'BRONZE LEVEL';
                        else
                            echo 'STARTER LEVEL';
                    @endphp
                </div>
                <div class="mt-4 w-full bg-white/5 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-yellow-500 h-full shadow-[0_0_10px_rgba(240,185,10,0.5)]"
                        style="width: {{ min(100, ($referralCount % 25) * 4) }}%"></div>
                </div>
            </div>

            <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-24 bg-blue-500/[0.03] blur-2xl"></div>
                <h4 class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-4">Invited By</h4>
                <div class="text-xs font-black text-white tracking-tighter uppercase truncate">
                    {{ $uc->getUserParent($usr) ?: 'NO ONE' }}
                </div>
                <div class="mt-5 text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                    Your Referrer
                </div>
            </div>
        </div>

        <!-- Link Relay Terminal -->
        <div class="dashboard-glass border-white/5 p-8 md:p-10">
            <div class="flex flex-col md:flex-row md:items-center gap-10">
                <div class="flex-1 space-y-6">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest border-b border-white/5 pb-4">Your
                        Invite Details</h3>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Your Invite
                            Link</label>
                        <div
                            class="flex rounded-2xl overflow-hidden border border-white/10 bg-black/40 group focus-within:border-yellow-500/50 transition-all">
                            <input type="text" value="{{ Auth::user()->ref_link }}" readonly
                                class="w-full bg-transparent px-6 py-5 text-sm font-mono text-slate-300 focus:outline-none">
                            <button
                                @click="navigator.clipboard.writeText('{{ Auth::user()->ref_link }}'); showCopied = true; setTimeout(() => showCopied = false, 2000)"
                                class="bg-white/5 hover:bg-white/10 px-8 text-yellow-500 border-l border-white/10 transition-all flex-shrink-0 active:scale-95">
                                <i data-lucide="copy" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <div x-show="showCopied" x-transition.opacity
                            class="text-emerald-400 text-[9px] font-black uppercase tracking-widest ml-1">
                            Link Copied to Clipboard
                        </div>
                    </div>

                    <div class="flex items-center space-x-10 pt-4">
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 block">Username</label>
                            <div class="text-xl font-black gold-text tracking-tighter">{{ Auth::user()->username }}
                            </div>
                        </div>
                        <div class="h-10 w-px bg-white/5"></div>
                        <div>
                            <label class="text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 block">Reward
                                Tier</label>
                            <div class="text-xl font-black text-white tracking-tighter">
                                @php
                                    if ($referralCount >= 100)
                                        echo '15%';
                                    elseif ($referralCount >= 50)
                                        echo '12%';
                                    elseif ($referralCount >= 25)
                                        echo '10%';
                                    elseif ($referralCount >= 10)
                                        echo '7%';
                                    else
                                        echo '5%';
                                @endphp Reward
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-64 space-y-4">
                    <div
                        class="p-6 rounded-3xl bg-white border border-black/[0.05] aspect-square flex flex-col items-center justify-center text-center shadow-2xl">
                        <div id="qrcode" class="mb-4"></div>
                        <p class="text-[9px] font-black text-black uppercase tracking-widest">Scan to Share
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Network Explorer -->
        <div class="dashboard-glass border-white/5 overflow-hidden">
            <div class="flex items-center p-1.5 bg-black/20 border-b border-white/5">
                <button @click="selectedTab = 'overview'"
                    :class="selectedTab === 'overview' ? 'bg-white/10 text-white' : 'text-slate-500 hover:text-white'"
                    class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    How it Works
                </button>
                <button @click="selectedTab = 'referrals'"
                    :class="selectedTab === 'referrals' ? 'bg-white/10 text-white' : 'text-slate-500 hover:text-white'"
                    class="px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                    Invited Friends
                </button>
            </div>

            <div class="p-8 md:p-10">
                <!-- Yield Manual -->
                <div x-show="selectedTab === 'overview'" x-transition.opacity class="space-y-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                        <div class="space-y-4">
                            <div
                                class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center text-yellow-500 font-black">
                                1</div>
                            <h4 class="text-xs font-black text-white uppercase tracking-widest">Share Your Link</h4>
                            <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed">Share your unique
                                invite link with friends via social media or messaging.</p>
                        </div>
                        <div class="space-y-4">
                            <div
                                class="h-10 w-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 font-black">
                                2</div>
                            <h4 class="text-xs font-black text-white uppercase tracking-widest">Friends Join</h4>
                            <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed">When someone signs up
                                using your link, they become part of your referral network.
                            </p>
                        </div>
                        <div class="space-y-4">
                            <div
                                class="h-10 w-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 font-black">
                                3</div>
                            <h4 class="text-xs font-black text-white uppercase tracking-widest">Earn Rewards</h4>
                            <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed">Earn rewards
                                automatically when your invited friends make their first deposit.</p>
                        </div>
                    </div>

                    <div class="dashboard-glass border-white/5 p-8 bg-white/[0.01]">
                        <h3 class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-6">Reward Tiers
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            <div class="p-4 rounded-2xl border border-white/5 text-center">
                                <div class="text-[10px] font-black text-slate-400 mb-1">STARTER</div>
                                <div class="text-lg font-black text-white">5%</div>
                            </div>
                            <div class="p-4 rounded-2xl border border-white/5 text-center bg-amber-500/5">
                                <div class="text-[10px] font-black text-amber-500 mb-1">BRONZE</div>
                                <div class="text-lg font-black text-white">7%</div>
                            </div>
                            <div class="p-4 rounded-2xl border border-white/5 text-center bg-slate-400/5">
                                <div class="text-[10px] font-black text-slate-300 mb-1">SILVER</div>
                                <div class="text-lg font-black text-white">10%</div>
                            </div>
                            <div class="p-4 rounded-2xl border border-white/5 text-center bg-yellow-500/5">
                                <div class="text-[10px] font-black text-yellow-500 mb-1">GOLD</div>
                                <div class="text-lg font-black text-white">12%</div>
                            </div>
                            <div class="p-4 rounded-2xl border border-white/5 text-center bg-purple-500/10">
                                <div class="text-[10px] font-black text-purple-400 mb-1">ELITE</div>
                                <div class="text-lg font-black text-white">15%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connected Nodes -->
                <div x-show="selectedTab === 'referrals'" x-transition.opacity>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                                <tr class="border-b border-white/5">
                                    <th class="px-6 py-4">Friend's Name</th>
                                    <th class="px-6 py-4">Level</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-8 py-4 text-right">Join Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/[0.02] text-xs font-bold text-slate-400">
                                {!! $uc->getdownlines($array, $usr) !!}
                            </tbody>
                        </table>
                    </div>

                    @if(count($array->where('ref_by', Auth::user()->id)) == 0)
                        <div class="py-20 text-center opacity-40">
                            <i data-lucide="network" class="w-10 h-10 mx-auto mb-6"></i>
                            <p class="text-[10px] font-black uppercase tracking-widest">No friends invited yet. Start sharing
                                your link!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Transmissions Modal -->
    <div x-show="showShareModal" x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/90 backdrop-blur-sm">
        <div class="bg-black border border-white/10 rounded-3xl p-10 max-w-md w-full relative overflow-hidden shadow-2xl">
            <div class="absolute inset-0 bg-yellow-500/[0.02] pointer-events-none"></div>
            <h3 class="text-lg font-black text-white uppercase tracking-tight mb-8">Share Link</h3>

            <div class="grid grid-cols-2 gap-4">
                <button @click="shareToSocial('twitter')"
                    class="h-16 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center group hover:bg-sky-500 transition-all">
                    <i data-lucide="twitter" class="w-6 h-6 text-slate-400 group-hover:text-white"></i>
                </button>
                <button @click="shareToSocial('facebook')"
                    class="h-16 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center group hover:bg-blue-600 transition-all">
                    <i data-lucide="facebook" class="w-6 h-6 text-slate-400 group-hover:text-white"></i>
                </button>
                <button @click="shareToSocial('linkedin')"
                    class="h-16 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center group hover:bg-blue-800 transition-all">
                    <i data-lucide="linkedin" class="w-6 h-6 text-slate-400 group-hover:text-white"></i>
                </button>
                <button @click="shareToSocial('whatsapp')"
                    class="h-16 rounded-2xl bg-white/[0.03] border border-white/5 flex items-center justify-center group hover:bg-emerald-500 transition-all">
                    <i data-lucide="message-circle" class="w-6 h-6 text-slate-400 group-hover:text-white"></i>
                </button>
            </div>

            <button @click="showShareModal = false"
                class="w-full mt-10 text-[9px] font-black text-slate-500 uppercase tracking-widest hover:text-white transition-colors">
                Close Menu
            </button>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();

            if (typeof QRCode !== 'undefined') {
                document.getElementById('qrcode').innerHTML = ""; // Clear if already present
                new QRCode(document.getElementById("qrcode"), {
                    text: "{{ Auth::user()->ref_link }}",
                    width: 140,
                    height: 140,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
            }
        });

        function shareToSocial(platform) {
                const url = '{{ Auth::user()->ref_link }}';
                const text = @json('Join me on ' . ($settings->site_name ?? config('app.name')) . ' and start investing today: ');
            let shareUrl = '';

            switch (platform) {
                case 'twitter': shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`; break;
                case 'facebook': shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`; break;
                case 'linkedin': shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`; break;
                case 'whatsapp': shareUrl = `https://wa.me/?text=${encodeURIComponent(text + url)}`; break;
            }

            if (shareUrl) window.open(shareUrl, '_blank', 'width=600,height=400');
        }
    </script>
@endpush