@extends('layouts.dasht')
@section('title', 'Identity Synchronized')
@section('content')
    @php
        $countryOptions = [];
        $regionOptionsByCountry = [];
        $countriesJsPath = base_path('temp/custom/assets/javascript/countries.js');

        if (is_file($countriesJsPath)) {
            $countriesJsContent = file_get_contents($countriesJsPath);
            if (preg_match('/var\s+country_arr\s*=\s*new Array\((.*?)\);/s', $countriesJsContent, $matches)) {
                preg_match_all('/"([^"]+)"/', $matches[1], $countryMatches);
                $countryOptions = $countryMatches[1] ?? [];
            }

            if (!empty($countryOptions) && preg_match_all('/s_a\[(\d+)\]\s*=\s*"([^"]*)"/', $countriesJsContent, $stateMatches, PREG_SET_ORDER)) {
                foreach ($stateMatches as $stateMatch) {
                    $countryIndex = (int) $stateMatch[1];
                    if ($countryIndex <= 0) {
                        continue;
                    }

                    $countryName = $countryOptions[$countryIndex - 1] ?? null;
                    if (!$countryName) {
                        continue;
                    }

                    $regions = array_values(array_filter(array_map('trim', explode('|', $stateMatch[2]))));
                    if (!empty($regions)) {
                        $regionOptionsByCountry[$countryName] = $regions;
                    }
                }
            }
        }
    @endphp
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="verificationForm()">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('account.verify') }}" class="hover:text-yellow-500 transition-colors">Registry</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Application</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Identity <span
                        class="gold-text">Verification</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Step <span x-text="currentStep"
                        class="text-white"></span>
                    of 3: Secure your account.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <i data-lucide="lock" class="w-4 h-4 mr-2 text-yellow-500"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">End-to-End Encryption</span>
                </div>
            </div>
        </div>

        <!-- Progress Indicator -->
        <div class="dashboard-glass border-white/5 p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xs font-black text-white uppercase tracking-widest">Verification Progress</h3>
                <span class="text-[10px] font-black gold-text uppercase tracking-[0.2em]" x-text="`${progress}%`"></span>
            </div>
            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden border border-white/5">
                <div class="h-full gold-gradient-bg shadow-[0_0_15px_rgba(240,185,10,0.3)] transition-all duration-700"
                    :style="`width: ${progress}%`"></div>
            </div>

            <div class="hidden md:grid grid-cols-3 gap-10 mt-8">
                <div class="flex items-center space-x-4 transition-all"
                    :class="currentStep >= 1 ? 'opacity-100' : 'opacity-30'">
                    <div class="h-10 w-10 rounded-xl flex items-center justify-center font-black text-xs"
                        :class="currentStep >= 1 ? 'bg-yellow-500 text-black' : 'bg-white/5 text-slate-500 border border-white/10'">
                        <span x-text="currentStep > 1 ? '' : '1'"></span>
                        <template x-if="currentStep > 1">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </template>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-white uppercase">Personal Details</div>
                        <div class="text-[9px] font-bold text-slate-600 uppercase">Basic Information</div>
                    </div>
                </div>

                <div class="flex items-center space-x-4 transition-all"
                    :class="currentStep >= 2 ? 'opacity-100' : 'opacity-30'">
                    <div class="h-10 w-10 rounded-xl flex items-center justify-center font-black text-xs"
                        :class="currentStep >= 2 ? 'bg-yellow-500 text-black' : 'bg-white/5 text-slate-500 border border-white/10'">
                        <span x-text="currentStep > 2 ? '' : '2'"></span>
                        <template x-if="currentStep > 2">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </template>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-white uppercase">Address Info</div>
                        <div class="text-[9px] font-bold text-slate-600 uppercase">Location Mapping</div>
                    </div>
                </div>

                <div class="flex items-center space-x-4 transition-all"
                    :class="currentStep >= 3 ? 'opacity-100' : 'opacity-30'">
                    <div class="h-10 w-10 rounded-xl flex items-center justify-center font-black text-xs"
                        :class="currentStep >= 3 ? 'bg-yellow-500 text-black' : 'bg-white/5 text-slate-500 border border-white/10'">
                        3</div>
                    <div>
                        <div class="text-[10px] font-black text-white uppercase">Document Upload</div>
                        <div class="text-[9px] font-bold text-slate-600 uppercase">Identity Proof</div>
                    </div>
                </div>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />
        <x-error-alert />

        <!-- Main Form Terminal -->
        <div class="max-w-4xl mx-auto">
            <div class="dashboard-glass border-white/5 overflow-hidden">
                <form action="{{ route('kycsubmit') }}" method="POST" enctype="multipart/form-data"
                    x-on:submit="isSubmitting = true">
                    @csrf

                    <!-- Step 1: Personal Info -->
                    <div x-show="currentStep === 1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-10"
                        x-transition:enter-end="opacity-100 translate-x-0" class="p-8 md:p-12 space-y-10">

                        <div class="border-b border-white/5 pb-6">
                            <h3 class="text-xl font-black text-white  uppercase tracking-tight mb-2">Personal <span
                                    class="gold-text">Identity</span></h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Provide core identity
                                data as documented on your government credentials.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Legal
                                    First Name</label>
                                <input type="text" name="first_name" required value="{{ Auth::user()->name }}"
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Legal
                                    Last Name</label>
                                <input type="text" name="last_name" required
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email
                                    Address</label>
                                <input type="email" name="email" required value="{{ Auth::user()->email }}"
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-slate-400 text-sm font-medium cursor-not-allowed"
                                    readonly>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Phone
                                    Number</label>
                                <input type="tel" name="phone_number" required value="{{ Auth::user()->phone_number }}"
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Date
                                    of Birth</label>
                                <input type="date" name="dob" required
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Social
                                    Media (Optional)</label>
                                <input type="text" name="social_media" placeholder="@username"
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700">
                            </div>
                        </div>

                        <div class="flex justify-end pt-6">
                            <button type="button" @click="currentStep = 2; progress = 66"
                                class="h-14 px-10 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.3em] shadow-xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3">
                                <span>Continue to Location</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Address Info -->
                    <div x-show="currentStep === 2" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-10"
                        x-transition:enter-end="opacity-100 translate-x-0" class="p-8 md:p-12 space-y-10" x-cloak>

                        <div class="border-b border-white/5 pb-6">
                            <h3 class="text-xl font-black text-white  uppercase tracking-tight mb-2">Address <span
                                    class="gold-text">Info</span></h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Specify your primary
                                residential address for your account.</p>
                        </div>

                        <div class="space-y-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Primary
                                    Street Address</label>
                                <input type="text" name="address" required placeholder="ENTIRE STREET ADDRESS..."
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">City/District</label>
                                    <input type="text" name="city" x-model="city" required list="city-suggestions"
                                        class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700">
                                    <datalist id="city-suggestions">
                                        <template x-for="region in availableStates" :key="`city-${region}`">
                                            <option :value="region"></option>
                                        </template>
                                    </datalist>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">State/Province</label>
                                    <template x-if="availableStates.length > 0">
                                        <div class="relative">
                                            <select name="state" x-model="state" required
                                                class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 pr-12 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all appearance-none">
                                                <option value="" class="bg-[#0b0f16] text-slate-400">Select State/Province</option>
                                                <template x-for="region in availableStates" :key="`state-${region}`">
                                                    <option :value="region" x-text="region" class="bg-[#0b0f16] text-white"></option>
                                                </template>
                                            </select>
                                            <i data-lucide="chevrons-up-down"
                                                class="w-4 h-4 text-slate-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                        </div>
                                    </template>
                                    <template x-if="availableStates.length === 0">
                                        <input type="text" name="state" x-model="state" required
                                            class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700"
                                            placeholder="Enter State/Province">
                                    </template>
                                </div>

                                <div class="space-y-3 md:col-span-2">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Country/Jurisdiction</label>
                                    <div class="relative">
                                        <select name="country" x-model="country" required
                                            class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-4 pr-12 text-white text-sm font-medium focus:outline-none focus:border-yellow-500/50 transition-all appearance-none">
                                            <option value="" class="bg-[#0b0f16] text-slate-400">Select Country</option>
                                            <template x-for="countryOption in allCountries" :key="countryOption">
                                                <option :value="countryOption" x-text="countryOption" class="bg-[#0b0f16] text-white">
                                                </option>
                                            </template>
                                        </select>
                                        <i data-lucide="chevrons-up-down"
                                            class="w-4 h-4 text-slate-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="p-8 rounded-2xl bg-white/[0.02] border border-white/5 space-y-6">
                                <label class="flex items-center space-x-4 cursor-pointer">
                                    <input type="checkbox" x-model="isUS"
                                        class="h-5 w-5 rounded bg-black border-white/10 text-yellow-500 focus:ring-yellow-500/50 focus:ring-offset-0">
                                    <span class="text-[11px] font-black text-slate-300 uppercase tracking-widest">Citizen or
                                        Resident of United States</span>
                                </label>

                                <div x-show="isUS" x-transition.opacity class="space-y-4 pt-4 border-t border-white/5">
                                    <div class="space-y-3">
                                        <label
                                            class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">SSN
                                            (Social Security Number)</label>
                                        <input type="text" name="ssn" x-bind:required="isUS" placeholder="XXX-XX-XXXX"
                                            class="w-full bg-black/50 border border-white/10 rounded-xl px-6 py-4 text-white text-lg font-black tracking-[0.3em] font-mono focus:outline-none focus:border-yellow-500/50 transition-all">
                                    </div>
                                    <p class="text-[9px] text-slate-600 font-bold uppercase">Your SSN is securely
                                        hashed and encrypted at rest.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6">
                            <button type="button" @click="currentStep = 1; progress = 33"
                                class="h-14 px-8 rounded-xl bg-white/5 border border-white/10 text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] hover:bg-white/10 hover:text-white transition-all order-2 sm:order-1 flex items-center justify-center space-x-3">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                <span>Previous Step</span>
                            </button>
                            <button type="button" @click="currentStep = 3; progress = 100"
                                class="h-14 px-10 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.3em] shadow-xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3 order-1 sm:order-2">
                                <span>Continue to Proof</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Proofs -->
                    <div x-show="currentStep === 3" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-10"
                        x-transition:enter-end="opacity-100 translate-x-0" class="p-8 md:p-12 space-y-10" x-cloak>

                        <div class="border-b border-white/5 pb-6">
                            <h3 class="text-xl font-black text-white  uppercase tracking-tight mb-2">Document <span
                                    class="gold-text">Upload</span></h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Upload clear photos of
                                your identity document.</p>
                        </div>

                        <div class="space-y-8">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Protocol
                                    Document Type</label>
                                <select name="document_type" x-model="documentType" required
                                    class="w-full bg-white/[0.02] border border-white/10 rounded-xl px-6 py-5 text-white text-xs font-black uppercase tracking-widest focus:outline-none focus:border-yellow-500/50 appearance-none cursor-pointer">
                                    <option value="" disabled selected>SELECT DOCUMENT GRADE...</option>
                                    <option value="Int'l Passport">INTERNATIONAL PASSPORT</option>
                                    <option value="National ID">NATIONAL ID CARD</option>
                                    <option value="Drivers License">DRIVER'S LICENSE</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Front -->
                                <div class="space-y-4">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Document
                                        Front Side</label>
                                    <div class="relative group h-48">
                                        <input type="file" name="frontimg" required accept="image/*"
                                            @change="frontPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                        <div
                                            class="absolute inset-0 rounded-2xl border-2 border-dashed border-white/10 bg-white/[0.01] group-hover:bg-white/[0.03] group-hover:border-yellow-500/30 transition-all flex flex-col items-center justify-center p-6 text-center">
                                            <template x-if="!frontPreview">
                                                <div class="space-y-3">
                                                    <i data-lucide="image" class="w-10 h-10 text-slate-600 mx-auto"></i>
                                                    <p
                                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                        Upload Front Image</p>
                                                </div>
                                            </template>
                                            <template x-if="frontPreview">
                                                <div class="relative w-full h-full">
                                                    <img :src="frontPreview"
                                                        class="w-full h-full object-cover rounded-xl border border-white/10 shadow-2xl">
                                                    <div
                                                        class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-xl">
                                                        <span
                                                            class="text-[10px] font-black text-white uppercase tracking-widest">Replace
                                                            Image</span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Back -->
                                <div class="space-y-4">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Document
                                        Back Side</label>
                                    <div class="relative group h-48">
                                        <input type="file" name="backimg" required accept="image/*"
                                            @change="backPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                        <div
                                            class="absolute inset-0 rounded-2xl border-2 border-dashed border-white/10 bg-white/[0.01] group-hover:bg-white/[0.03] group-hover:border-yellow-500/30 transition-all flex flex-col items-center justify-center p-6 text-center">
                                            <template x-if="!backPreview">
                                                <div class="space-y-3">
                                                    <i data-lucide="image" class="w-10 h-10 text-slate-600 mx-auto"></i>
                                                    <p
                                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                        Upload Back Image</p>
                                                </div>
                                            </template>
                                            <template x-if="backPreview">
                                                <div class="relative w-full h-full">
                                                    <img :src="backPreview"
                                                        class="w-full h-full object-cover rounded-xl border border-white/10 shadow-2xl">
                                                    <div
                                                        class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-xl">
                                                        <span
                                                            class="text-[10px] font-black text-white uppercase tracking-widest">Replace
                                                            Image</span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <!-- Face -->
                                <div class="md:col-span-2 space-y-4">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Liveness
                                        Verification (Selfie)</label>
                                    <div class="relative group h-64">
                                        <input type="file" name="face_img" required accept="image/*"
                                            @change="facePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                        <div
                                            class="absolute inset-0 rounded-2xl border-2 border-dashed border-white/10 bg-white/[0.01] group-hover:bg-white/[0.03] group-hover:border-blue-500/30 transition-all flex flex-col items-center justify-center p-6 text-center">
                                            <template x-if="!facePreview">
                                                <div class="space-y-4">
                                                    <div
                                                        class="h-16 w-16 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mx-auto">
                                                        <i data-lucide="user" class="w-8 h-8 text-blue-400"></i>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                                        Take a Selfie</p>
                                                    <p class="text-[8px] font-bold text-slate-600 uppercase">Ensure full
                                                        face visibility.</p>
                                                </div>
                                            </template>
                                            <template x-if="facePreview">
                                                <div class="relative w-full h-full">
                                                    <img :src="facePreview"
                                                        class="w-full h-full object-contain rounded-xl border border-white/10 shadow-2xl">
                                                    <div
                                                        class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-xl">
                                                        <span
                                                            class="text-[10px] font-black text-white uppercase tracking-widest">Rescan
                                                            Identity</span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 rounded-2xl bg-yellow-500/5 border border-yellow-500/10">
                            <label class="flex items-start space-x-4 cursor-pointer">
                                <input type="checkbox" required
                                    class="mt-1 h-5 w-5 rounded bg-black border-white/10 text-yellow-500 focus:ring-yellow-500/50 focus:ring-offset-0">
                                <span class="text-[10px] font-bold text-slate-400 uppercase leading-relaxed">
                                    I hereby confirm that all submitted data is accurate and corresponds to my legal
                                    physical identity. I acknowledge that falsifying registry entries will result in
                                    immediate account suspension.
                                </span>
                            </label>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between gap-4 pt-6">
                            <button type="button" @click="currentStep = 2; progress = 66"
                                class="h-14 px-8 rounded-xl bg-white/5 border border-white/10 text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] hover:bg-white/10 hover:text-white transition-all order-2 sm:order-1 flex items-center justify-center space-x-3">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                <span>Return to Hub</span>
                            </button>

                            <button type="submit" :disabled="isSubmitting"
                                class="h-16 px-12 rounded-xl bg-gradient-to-r from-yellow-500 to-amber-600 text-black font-black text-[11px] uppercase tracking-[0.4em] shadow-2xl shadow-yellow-500/30 hover:scale-[1.05] transform transition-all active:scale-95 flex items-center justify-center space-x-4 order-1 sm:order-2">
                                <span x-show="!isSubmitting">Submit Verification</span>
                                <span x-show="isSubmitting">SUBMITTING...</span>
                                <i data-lucide="zap" class="w-5 h-5" x-show="!isSubmitting"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('verificationForm', () => ({
                currentStep: 1,
                documentType: '',
                country: @js(old('country', Auth::user()->country ?? '')),
                state: @js(old('state', '')),
                city: @js(old('city', '')),
                isSubmitting: false,
                progress: 33,
                showPreview: false,
                frontPreview: null,
                backPreview: null,
                facePreview: null,
                allCountries: @js($countryOptions),
                regionsByCountry: @js($regionOptionsByCountry),
                availableStates: [],
                isLoadingCountries: false,
                isUS: false,

                syncAvailableStates() {
                    const regions = this.regionsByCountry[this.country] ?? [];
                    this.availableStates = Array.isArray(regions) ? regions : [];

                    if (this.availableStates.length > 0 && this.state && !this.availableStates.includes(this.state)) {
                        this.state = '';
                    }
                },

                init() {
                    this.syncAvailableStates();

                    if (this.country === 'USA') {
                        this.isUS = true;
                    }

                    this.$watch('country', (value) => {
                        this.isUS = value === 'USA';
                        this.syncAvailableStates();
                    });

                    lucide.createIcons();
                }
            }));
        });
    </script>
@endpush
