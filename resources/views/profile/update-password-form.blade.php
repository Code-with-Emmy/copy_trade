<div x-data="passwordLogic()" class="space-y-12">
    <form method="POST" action="{{ route('updateuserpass') }}" class="space-y-10">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Current Password -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Legacy Encryption
                    Key (Current Password)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="key"
                            class="h-4 w-4 text-slate-600 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <input :type="showOld ? 'text' : 'password'" name="current_password" required
                        class="w-full bg-black/40 border border-white/5 rounded-xl py-4 pl-12 pr-12 text-sm text-white font-medium focus:border-yellow-500/50 focus:outline-none transition-all placeholder:text-slate-700">
                    <button type="button" @click="showOld = !showOld"
                        class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-600 hover:text-white transition-colors">
                        <i data-lucide="eye" class="h-4 w-4" x-show="!showOld"></i>
                        <i data-lucide="eye-off" class="h-4 w-4" x-show="showOld" style="display: none;"></i>
                    </button>
                </div>
            </div>

            <!-- New Password -->
            <div class="space-y-3">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">New Protocol Key
                    (New Password)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="lock"
                            class="h-4 w-4 text-slate-600 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <input :type="showNew ? 'text' : 'password'" name="password" required
                        @input="checkStrength($event.target.value)"
                        class="w-full bg-black/40 border border-white/5 rounded-xl py-4 pl-12 pr-12 text-sm text-white font-medium focus:border-yellow-500/50 focus:outline-none transition-all placeholder:text-slate-700">
                    <button type="button" @click="showNew = !showNew"
                        class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-600 hover:text-white transition-colors">
                        <i data-lucide="eye" class="h-4 w-4" x-show="!showNew"></i>
                        <i data-lucide="eye-off" class="h-4 w-4" x-show="showNew" style="display: none;"></i>
                    </button>
                </div>

                <!-- Strength Meter -->
                <div class="mt-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[8px] font-black uppercase tracking-widest" :class="getStrengthColor"
                            x-text="'Entropy: ' + feedback"></span>
                        <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest"
                            x-text="strength + '%'"></span>
                    </div>
                    <div class="h-1 w-full bg-white/5 rounded-full overflow-hidden">
                        <div class="h-full transition-all duration-500 shadow-[0_0_10px_rgba(240,185,10,0.3)]"
                            :class="getStrengthBg" :style="`width: ${strength}%`"></div>
                    </div>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="space-y-3 md:col-span-2">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Key Validation
                    (Confirm Password)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="check-circle"
                            class="h-4 w-4 text-slate-600 group-focus-within:text-yellow-500 transition-colors"></i>
                    </div>
                    <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                        class="w-full bg-black/40 border border-white/5 rounded-xl py-4 pl-12 pr-12 text-sm text-white font-medium focus:border-yellow-500/50 focus:outline-none transition-all placeholder:text-slate-700">
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute inset-y-0 right-0 px-4 flex items-center text-slate-600 hover:text-white transition-colors">
                        <i data-lucide="eye" class="h-4 w-4" x-show="!showConfirm"></i>
                        <i data-lucide="eye-off" class="h-4 w-4" x-show="showConfirm" style="display: none;"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-6 flex justify-end">
            <button type="submit"
                class="h-14 px-10 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.3em] shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transform transition-all active:scale-95 flex items-center space-x-3">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span>Rotate Encryption Key</span>
            </button>
        </div>
    </form>

    <!-- Requirements Grid -->
    <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-8 rounded-3xl bg-white/[0.02] border border-white/5">
        <div class="flex flex-col space-y-2">
            <div class="flex items-center space-x-3">
                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                <span class="text-[9px] font-black text-white uppercase tracking-widest">Length Pattern</span>
            </div>
            <p class="text-[8px] text-slate-600 font-bold uppercase ml-6">Min 8 Characters Required</p>
        </div>
        <div class="flex flex-col space-y-2">
            <div class="flex items-center space-x-3">
                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                <span class="text-[9px] font-black text-white uppercase tracking-widest">Casing Variety</span>
            </div>
            <p class="text-[8px] text-slate-600 font-bold uppercase ml-6">Upper & Lower Case Mix</p>
        </div>
        <div class="flex flex-col space-y-2">
            <div class="flex items-center space-x-3">
                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                <span class="text-[9px] font-black text-white uppercase tracking-widest">Symbol Cluster</span>
            </div>
            <p class="text-[8px] text-slate-600 font-bold uppercase ml-6">Special Symbols Optional</p>
        </div>
        <div class="flex flex-col space-y-2">
            <div class="flex items-center space-x-3">
                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                <span class="text-[9px] font-black text-white uppercase tracking-widest">Numeric Hash</span>
            </div>
            <p class="text-[8px] text-slate-600 font-bold uppercase ml-6">Integers Included</p>
        </div>
    </div>
</div>

<script>
    function passwordLogic() {
        return {
            showOld: false, showNew: false, showConfirm: false,
            strength: 0, feedback: 'UNSET',
            checkStrength(p) {
                if (!p) { this.strength = 0; this.feedback = 'UNSET'; return; }
                let s = 0;
                if (p.length >= 8) s += 25;
                if (/[a-z]/.test(p) && /[A-Z]/.test(p)) s += 25;
                if (/[0-9]/.test(p)) s += 25;
                if (/[^A-Za-z0-9]/.test(p)) s += 25;
                this.strength = s;
                this.feedback = s < 50 ? 'VULNERABLE' : (s < 75 ? 'STABLE' : 'HARDENED');
            },
            get getStrengthColor() {
                return this.strength < 50 ? 'text-rose-500' : (this.strength < 75 ? 'text-yellow-500' : 'text-emerald-500');
            },
            get getStrengthBg() {
                return this.strength < 50 ? 'bg-rose-500' : (this.strength < 75 ? 'bg-yellow-500' : 'bg-emerald-500');
            }
        }
    }
</script>