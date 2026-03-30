<div id="editModal{{ $list->id }}" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content overflow-hidden rounded-[30px] border border-white/10 bg-[#0b1220] shadow-[0_32px_80px_rgba(0,0,0,0.55)]">
            <div class="border-b border-white/10 bg-[radial-gradient(circle_at_top_right,_rgba(240,185,10,0.16),_transparent_38%),linear-gradient(135deg,_rgba(8,11,18,0.98),_rgba(15,23,42,0.94))] px-6 py-5 sm:px-8">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="mb-2 text-[10px] font-black uppercase tracking-[0.22em] text-slate-500">CRM Status Note</p>
                        <h4 class="mb-2 text-2xl font-black tracking-tight text-white">Edit This User Status</h4>
                        <p class="mb-0 max-w-2xl text-sm font-medium leading-6 text-slate-400">
                            Update the latest outreach note, onboarding context, or conversion remark for <span class="text-white">{{ $list->name }}</span>.
                        </p>
                    </div>
                    <button type="button"
                        class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-400 transition-all hover:bg-white/10 hover:text-white"
                        data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>

            <div class="px-6 py-6 sm:px-8">
                <form method="post" action="{{ route('updateuser') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="id" value="{{ $list->id }}">

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-4">
                            <p class="mb-2 text-[10px] font-black uppercase tracking-widest text-slate-500">Investor</p>
                            <p class="mb-0 text-sm font-semibold text-white">{{ $list->name }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-4">
                            <p class="mb-2 text-[10px] font-black uppercase tracking-widest text-slate-500">Email</p>
                            <p class="mb-0 break-all text-sm font-semibold text-white">{{ $list->email }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-4">
                            <p class="mb-2 text-[10px] font-black uppercase tracking-widest text-slate-500">Current Status</p>
                            <p class="mb-0 text-sm font-semibold {{ ($list->status ?? '') === 'active' ? 'text-emerald-400' : 'text-rose-400' }}">
                                {{ ucfirst((string) ($list->status ?: 'inactive')) }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="userupdate{{ $list->id }}" class="mb-3 block text-[10px] font-black uppercase tracking-[0.22em] text-slate-500">
                            Status Update
                        </label>
                        <textarea
                            name="userupdate"
                            id="userupdate{{ $list->id }}"
                            rows="6"
                            class="w-full rounded-[24px] border border-white/10 bg-black/30 px-5 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                            placeholder="Write the latest follow-up note, disposition, or account update here."
                            required>{{ $list->userupdate }}</textarea>
                        <p class="mt-3 mb-0 text-xs font-medium text-slate-500">
                            This note is used by the admin team to track the user’s latest CRM status and next action.
                        </p>
                    </div>

                    <div class="flex flex-wrap justify-end gap-3">
                        <button type="button" class="btn btn-outline-light btn-sm" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4">Save Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
