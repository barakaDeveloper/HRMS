@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="p-4 sm:p-6">
    <!-- Page Header -->
    <div class="panel p-4 sm:p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-bold logo-text">Company Settings</h1>
                <p class="text-[var(--muted)] text-sm sm:text-base">Manage your company information and configurations</p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Company Information Card -->
        <div class="panel p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-[var(--g-spring)] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h2 class="text-lg sm:text-xl font-bold">Company Information</h2>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <div>
                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-1">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="company_name" 
                           class="w-full px-3 py-2 rounded-lg border border-[var(--border-color)] bg-[var(--panel)] focus:outline-none focus:border-[var(--g-spring)] @error('company_name') border-red-500 @enderror" 
                           value="{{ old('company_name', $settings['company_name'] ?? '') }}" 
                           required
                           placeholder="Enter company name">
                    @error('company_name')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-1">
                        Company Address <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="company_address" 
                           class="w-full px-3 py-2 rounded-lg border border-[var(--border-color)] bg-[var(--panel)] focus:outline-none focus:border-[var(--g-spring)] @error('company_address') border-red-500 @enderror" 
                           value="{{ old('company_address', $settings['company_address'] ?? '') }}" 
                           required
                           placeholder="Enter company address">
                    @error('company_address')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Currency Settings Card -->
        <div class="panel p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-[var(--g-poly)] flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-lg sm:text-xl font-bold">Currency Settings</h2>
            </div>
            
            <div class="flex flex-wrap items-end gap-3 sm:gap-4">
                <div>
                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-1">
                        USD Exchange Rate to TZS
                    </label>
                    <div class="flex" style="width: 220px;">
                        <span class="px-3 py-2 rounded-l-lg bg-[var(--chip-bg)] border border-[var(--border-color)] border-r-0 text-[var(--muted)] text-xs flex items-center whitespace-nowrap">1 USD =</span>
                        <input type="number" 
                               name="usd_exchange_rate" 
                               class="w-full px-3 py-2 rounded-r-lg border border-[var(--border-color)] bg-[var(--panel)] focus:outline-none focus:border-[var(--g-spring)] @error('usd_exchange_rate') border-red-500 @enderror" 
                               value="{{ old('usd_exchange_rate', $settings['usd_exchange_rate'] ?? 2500) }}" 
                               min="1"
                               step="1"
                               placeholder="2500">
                        <span class="px-3 py-2 rounded-r-lg bg-[var(--chip-bg)] border border-[var(--border-color)] border-l-0 text-[var(--muted)] font-bold text-xs">TZS</span>
                    </div>
                    @error('usd_exchange_rate')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror

                    <small class="text-[var(--muted)] text-xs">This rate will be used for salary slip calculations</small>
                </div>
                
            </div>
        </div>
        
        <!-- Logo & Signature Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
            <!-- Company Logo Card -->
            <div class="panel p-4 sm:p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg sm:text-xl font-bold">Company Logo</h2>
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-1">
                        Upload Logo
                    </label>
                    <input type="file" 
                           name="company_logo" 
                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--g-spring)] file:text-white hover:file:bg-[var(--g-poly)]"
                           accept="image/*">
                    @error('company_logo')
                        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                    @enderror
                    <small class="text-[var(--muted)] text-xs mt-1 d-block">Supported: JPG, PNG, GIF (Max 2MB)</small>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-[var(--accent-text)] mb-1">
                        Current Logo
                    </label>
                    <div class="panel p-3 bg-[var(--chip-bg)] text-center rounded-lg min-h-[60px] sm:min-h-[80px] flex items-center justify-center">
                        @if(!empty($settings['company_logo']) && file_exists(public_path($settings['company_logo'])))
                            <img src="{{ asset($settings['company_logo']) }}" 
                                 alt="Company Logo" 
                                 class="img-fluid" 
                                 style="max-height: 60px;">
                        @else
                            <p class="text-[var(--muted)] text-xs sm:text-sm mb-0">No logo uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- HR/Finance Signature Card -->
            <div class="panel p-4 sm:p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-lg bg-yellow-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold">HR/Finance Signature</h2>
                </div>
                
                <div class="mb-4">
                    <label class="chip bg-transparent border-0 px-0 text-[var(--accent-text)] font-semibold mb-2">
                        Upload Signature
                    </label>
                    <input type="file" 
                           name="hr_finance_signature" 
                           class="chip w-full focus:ring-2 focus:ring-[var(--g-spring)] file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[var(--g-spring)] file:text-white hover:file:bg-[var(--g-poly)]"
                           accept="image/*">
                    @error('hr_finance_signature')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                    <small class="text-[var(--muted)] text-sm mt-1 d-block">Supported: JPG, PNG, GIF (Max 2MB)</small>
                </div>
                
                <div>
                    <label class="chip bg-transparent border-0 px-0 text-[var(--accent-text)] font-semibold mb-2">
                        Current Signature
                    </label>
                    <div class="panel p-4 bg-[var(--chip-bg)] text-center rounded-lg min-h-[80px] flex items-center justify-center">
                        @if(!empty($settings['hr_finance_signature']) && file_exists(public_path($settings['hr_finance_signature'])))
                            <img src="{{ asset($settings['hr_finance_signature']) }}" 
                                 alt="HR/Finance Signature" 
                                 class="img-fluid" 
                                 style="max-height: 80px;">
                        @else
                            <p class="text-[var(--muted)] text-sm mb-0">No signature uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-end gap-3">
            <button type="reset" class="chip flex items-center justify-center gap-2 hover:bg-[var(--hover-bg)] px-6 py-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Reset
            </button>
            <button type="submit" class="chip flex items-center justify-center gap-2 bg-[var(--g-spring)] text-white hover:bg-[var(--g-poly)] transition-colors px-6 py-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    /* Ensure panel inputs have proper styling */
    .panel.input {
        background: var(--panel);
        border: 1px solid var(--border-color);
    }
    
    .panel:focus {
        outline: none;
        border-color: var(--g-spring);
    }
</style>
@endpush
