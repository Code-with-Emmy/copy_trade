<div x-data="{ saving: false }">
    <form method="POST" action="javascript:void(0)" id="updateprofileform" class="space-y-10">
        <?php echo csrf_field(); ?>

        <div class="space-y-10">
            <!-- Grid Layout for Personal Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Legal Name -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Node Identifier
                        (Full Name)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="user"
                                class="h-4 w-4 text-slate-600 group-focus-within:text-yellow-500 transition-colors"></i>
                        </div>
                        <input type="text" name="name" value="<?php echo e(Auth::user()->name); ?>" required
                            class="w-full bg-black/40 border border-white/5 rounded-xl py-4 pl-12 pr-4 text-sm text-white font-medium focus:border-yellow-500/50 focus:outline-none transition-all placeholder:text-slate-700">
                    </div>
                </div>

                <!-- Phone Uplink -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Comms Uplink
                        (Phone)</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="phone"
                                class="h-4 w-4 text-slate-600 group-focus-within:text-yellow-500 transition-colors"></i>
                        </div>
                        <input type="text" name="phone" value="<?php echo e(Auth::user()->phone); ?>" required
                            class="w-full bg-black/40 border border-white/5 rounded-xl py-4 pl-12 pr-4 text-sm text-white font-medium focus:border-yellow-500/50 focus:outline-none transition-all placeholder:text-slate-700">
                    </div>
                </div>

                <!-- Email Relay (Locked) -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Relay Email
                        (Static)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-4 w-4 text-slate-400 opacity-50"></i>
                        </div>
                        <input type="text" value="<?php echo e(Auth::user()->email); ?>" readonly
                            class="w-full bg-white/[0.02] border border-white/5 rounded-xl py-4 pl-12 pr-4 text-sm text-slate-500 font-medium cursor-not-allowed">
                        <div class="absolute inset-y-0 right-4 flex items-center">
                            <i data-lucide="lock" class="h-3 w-3 text-slate-700"></i>
                        </div>
                    </div>
                </div>

                <!-- Username (Locked) -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Terminal Alias
                        (Static)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i data-lucide="at-sign" class="h-4 w-4 text-slate-400 opacity-50"></i>
                        </div>
                        <input type="text" value="<?php echo e(Auth::user()->username); ?>" readonly
                            class="w-full bg-white/[0.02] border border-white/5 rounded-xl py-4 pl-12 pr-4 text-sm text-slate-500 font-medium cursor-not-allowed">
                        <div class="absolute inset-y-0 right-4 flex items-center">
                            <i data-lucide="lock" class="h-3 w-3 text-slate-700"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jurisdiction Selection -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Jurisdictional
                    Governance (Country)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="globe"
                            class="h-4 w-4 text-slate-600 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <select name="country" required
                        class="w-full bg-black/40 border border-white/5 rounded-xl py-4 pl-12 pr-10 text-sm text-white font-medium focus:border-yellow-500/50 focus:outline-none transition-all appearance-none cursor-pointer">
                        <option value="<?php echo e(Auth::user()->country); ?>" selected disabled><?php echo e(Auth::user()->country); ?>

                        </option>
                        <?php echo $__env->make('profile.partials.country-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </select>
                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-600">
                        <i data-lucide="chevron-down" class="h-4 w-4"></i>
                    </div>
                </div>
            </div>

            <!-- Submit Action -->
            <div class="pt-10 flex justify-end items-center space-x-6">
                <div x-show="saving" x-transition class="flex items-center space-x-3">
                    <div class="h-2 w-2 rounded-full bg-yellow-500 animate-ping"></div>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic">broadcasting
                        updates...</span>
                </div>

                <button type="submit" :disabled="saving"
                    class="h-14 px-10 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.3em] shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transform transition-all active:scale-95 flex items-center space-x-3">
                    <i data-lucide="save" class="w-4 h-4" x-show="!saving"></i>
                    <i data-lucide="refresh-cw" class="w-4 h-4 animate-spin" x-show="saving" style="display: none;"></i>
                    <span x-text="saving ? 'Processing' : 'Commit Changes'"></span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') { lucide.createIcons(); }

        $('#updateprofileform').on('submit', function (e) {
            e.preventDefault();
            const $form = $(this);
            const alpineData = document.querySelector('[x-data]').__x.$data;
            alpineData.saving = true;

            $.ajax({
                url: "<?php echo e(route('profile.update')); ?>",
                type: 'POST',
                data: $form.serialize(),
                success: function (response) {
                    if (response.status === 200) {
                        Swal.fire({
                            title: 'PROTOCOL SYNCED',
                            text: response.success,
                            icon: 'success',
                            background: '#0a0a0a',
                            color: '#fff',
                            confirmButtonColor: '#f0b90a'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'SYNC ERROR',
                        text: 'Encryption layer failed to commit profile updates.',
                        icon: 'error',
                        background: '#0a0a0a',
                        color: '#fff',
                        confirmButtonColor: '#ff2d55'
                    });
                },
                complete: function () {
                    alpineData.saving = false;
                }
            });
        });
    });
</script><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/profile/update-profile-information-form.blade.php ENDPATH**/ ?>