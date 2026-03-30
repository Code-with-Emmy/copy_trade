@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Broadcast Desk</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Email <span class="gold-text">Services</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Send targeted broadcast updates to the full user base, inactive investors, deposit-free users, or a hand-picked segment.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="https://t.me/+VRumJJSKKGdjM2I0" target="_blank"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="life-buoy" class="mr-2 h-4 w-4"></i>
                    Help
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-8 xl:col-span-2">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Create Broadcast</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Segment users, define the greeting, and compose the outgoing message</p>
                </div>

                <form method="post" action="{{ route('sendmailtoall') }}" class="mt-6 space-y-6">
                    @csrf

                    <label class="block">
                        <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Audience Segment</span>
                        <select class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" id="category" name="category">
                            <option value="All">All Users</option>
                            <option value="No active plans">Users without active investment plan</option>
                            <option value="No deposit">Users without any deposit</option>
                            <option value="Select Users">Choose users manually</option>
                        </select>
                    </label>

                    <div class="hidden" id="select-user-view">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">
                                Select Users (<span class="text-yellow-400" id="numofusers">0</span>)
                            </span>
                            <select onChange="SelectPage(this)" name="users[]" multiple class="form-control select2" style="width: 100%" id="showusers"></select>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Greeting</span>
                            <input type="text" value="Hello" name="greet"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Audience Title</span>
                            <input type="text" value="Investor" name="title"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        </label>
                    </div>

                    <label class="block">
                        <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Subject</span>
                        <input type="text" name="subject" required
                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Message Body</span>
                        <textarea class="ckeditor" name="message" rows="10" required></textarea>
                    </label>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                            class="rounded-2xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black transition-all hover:scale-[1.02]">
                            Send Broadcast
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="dashboard-glass p-6 sm:p-7">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Recommended Uses</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-400">
                        <p>Notify users about new plans, payouts, copy trading opportunities, and platform maintenance windows.</p>
                        <p>Target “No active plans” or “No deposit” to recover dormant users without broadcasting to everyone.</p>
                        <p>Use “Choose users manually” when you need a high-touch outreach sequence for VIP or support cases.</p>
                    </div>
                </div>

                <div class="dashboard-glass p-6 sm:p-7">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Broadcast Discipline</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-400">
                        <p>Keep the subject action-oriented and short.</p>
                        <p>Use the title and greeting fields to keep messages sounding intentional instead of generic.</p>
                        <p>Prefer segmented sends when the message is only relevant to a subset of users.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script type="text/javascript">
        var category = document.querySelector("#category");

        function toggleUserSelector() {
            if (category.value === "Select Users") {
                document.querySelector("#select-user-view").classList.remove("hidden");
            } else {
                document.querySelector("#select-user-view").classList.add("hidden");
            }
        }

        toggleUserSelector();
        $('.select2').select2();

        function SelectPage(elem) {
            var options = elem.options;
            var count = 0;
            for (var i = 0; i < options.length; i++) {
                if (options[i].selected) count++;
            }
            document.querySelector("#numofusers").textContent = count;
        }

        category.addEventListener('change', function() {
            toggleUserSelector();

            if (category.value === "Select Users" && !document.querySelector('#showusers').dataset.loaded) {
                var users = document.querySelector('#showusers');
                fetch("{{ route('fetchusers') }}")
                    .then(response => response.json())
                    .then(data => {
                        data.data.forEach(element => {
                            var usersopt = document.createElement('option');
                            usersopt.value = element.id;
                            usersopt.innerHTML = element.name;
                            users.appendChild(usersopt);
                        });
                        users.dataset.loaded = 'true';
                        $('#showusers').trigger('change');
                    });
            }
        });

        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endsection
