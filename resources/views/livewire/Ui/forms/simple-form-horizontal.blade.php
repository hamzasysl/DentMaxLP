@php
    $isDark = ($variant ?? 'dark') === 'dark';

    $invalid = $isDark
    ? 'border-red-400/60 ring-1 ring-red-400/30 focus:border-red-400 focus:ring-red-400/40'
    : 'border-red-500/50 ring-1 ring-red-500/20 focus:border-red-500 focus:ring-red-500/30';

    // Left texts
    $kicker = $isDark ? 'text-main-200/70' : 'text-main-900/60';
    $title  = $isDark ? 'text-white'       : 'text-main-900';
    $desc   = $isDark ? 'text-main-100/70' : 'text-gray-600';
    $hint   = $isDark ? 'text-gray-300'    : 'text-gray-500';

    // Form labels + fields
    $label = $isDark ? 'text-main-100/70' : 'text-main-900/60';

    $field = $isDark
        ? 'border-white/15 bg-white/5 text-white placeholder:text-main-200/60 focus:border-brand-400 focus:ring-brand-400/70'
        : 'border-gray-200 bg-white text-main-900 placeholder:text-gray-400 focus:border-brand-500 focus:ring-brand-500/20';

    // Success + Error
    $successBox = $isDark
        ? 'border-white/10 bg-main-900/60 text-main-100'
        : 'border-gray-200 bg-white text-main-900';

        // Alerts (Success/Fail) - Variant aware
    $alertBox = $isDark
        ? 'border-white/10 bg-main-900/60 text-main-100 backdrop-blur-md shadow-[0_12px_40px_rgba(0,0,0,.35)]'
        : 'border-main-200 bg-white/80 text-main-900 backdrop-blur shadow-[0_16px_40px_rgba(0,0,0,0.06)]';

    $alertKicker = $isDark ? 'text-main-100/70' : 'text-main-500';
    $alertBody   = $isDark ? 'text-main-100/85' : 'text-main-700';

    $dotSuccess = $isDark ? 'bg-brand-400/90 shadow-[0_0_0_3px_rgba(255,255,255,.06)]'
                          : 'bg-brand-500 shadow-[0_0_0_3px_rgba(207,106,6,.10)]';

    $dotFail    = $isDark ? 'bg-red-400/90 shadow-[0_0_0_3px_rgba(255,255,255,.06)]'
                          : 'bg-red-500 shadow-[0_0_0_3px_rgba(239,68,68,.12)]';

    $alertClose = $isDark
        ? 'border-white/10 bg-white/5 text-main-100/70 hover:text-white hover:bg-white/10'
        : 'border-main-200 bg-white/70 text-main-500 hover:text-main-900 hover:border-main-300';


    $errorText = $isDark ? 'text-red-300' : 'text-red-500';
@endphp

<div class="space-y-4 relative">

    {{-- SUCCESS --}}
    @if($success)
        <div class="mb-5 rounded-2xl border px-5 py-4 {{ $alertBox }}">
            <div class="flex items-start gap-3">
                <!-- Success Dot -->
                <div class="relative mt-0.5 h-2.5 w-2.5 shrink-0">
                    <span class="absolute inset-0 block rounded-full bg-emerald-400/60 animate-ping"></span>
                    <span class="absolute -inset-2 block rounded-full bg-emerald-400/20 blur-md"></span>
                    <span class="absolute inset-0 block rounded-full bg-emerald-400 shadow-[0_0_0_3px_rgba(16,185,129,0.18)]"></span>
                </div>

                <div class="min-w-0">
                    <div class="text-[11px] uppercase tracking-[0.24em] {{ $alertKicker }}">
                        {{ __('forms.consultation.request-received') }}
                    </div>
                    <div class="mt-1 text-[13px] font-light leading-relaxed {{ $alertBody }}">
                        {{ __('forms.consultation.request-received-text') }}
                    </div>
                </div>

                <button
                    type="button"
                    wire:click="$set('success', false)"
                    class="ml-auto inline-flex h-9 w-9 items-center justify-center rounded-full border cursor-pointer transition {{ $alertClose }}"
                >
                    ×
                </button>
            </div>
        </div>
    @endif


    {{-- FAILED --}}
    @if($submitFailed)
        <div class="mb-5 rounded-2xl border px-5 py-4 {{ $alertBox }}">
            <div class="flex items-start gap-3">
                <!-- Failed Dot -->
                <div class="relative mt-0.5 h-2.5 w-2.5 shrink-0">
                    <span class="absolute inset-0 block rounded-full bg-red-400/60 animate-ping"></span>
                    <span class="absolute -inset-2 block rounded-full bg-red-400/20 blur-md"></span>
                    <span class="absolute inset-0 block rounded-full bg-red-400 shadow-[0_0_0_3px_rgba(248,113,113,0.18)]"></span>
                </div>

                <div class="min-w-0">
                    <div class="text-[11px] uppercase tracking-[0.24em] {{ $alertKicker }}">
                        {{ __('forms.consultation.failed-to-receive') }}
                    </div>
                    <div class="mt-1 text-[13px] font-light leading-relaxed {{ $alertBody }}">
                        {{ __('forms.consultation.failed-to-receive-text') }}
                    </div>
                    @if($submitError)
                        <div class="mt-2 text-[11px] font-mono break-all opacity-75 {{ $alertBody }}">
                            {{ $submitError }}
                        </div>
                    @endif
                </div>

                <button
                    type="button"
                    wire:click="$set('submitFailed', false)"
                    class="ml-auto inline-flex h-9 w-9 items-center justify-center rounded-full border cursor-pointer transition {{ $alertClose }}"
                >
                    ×
                </button>
            </div>
        </div>
    @endif

    @error('form')
    <p class="mt-3 text-xs text-red-300">{{ $message }}</p>
    @enderror


    <form wire:submit.prevent="submit"
          class="flex flex-col gap-6 lg:flex-row lg:items-center lg:gap-10">

        {{-- Honeypot --}}
        <x-input type="text" wire:model="company" class="hidden" tabindex="-1" autocomplete="off" />

        <!-- LEFT -->
        <div class="max-w-xl lg:mr-10 space-y-1">
            <p class="text-[11px] tracking-[0.24em] uppercase {{ $kicker }}">
                {{ __('forms.consultation.kicker') }}
            </p>
            <h2 class="text-[24px] sm:text-[25px] capitalize font-semibold {{ $title }}">
                {{ __('forms.consultation.title') }}
            </h2>
            <p class="text-[12px] {{ $desc }}">
                {{ __('forms.consultation.desc') }}
            </p>

            @once
                <style>
                    @keyframes soft-pop {
                        0%, 100% { transform: scale(1); opacity: 1; }
                        50%      { transform: scale(1.06); opacity: 1; }
                    }
                    @keyframes soft-ring {
                        0%, 100% { transform: scale(1); opacity: .18; }
                        50%      { transform: scale(1.15); opacity: 0.56; }
                    }
                </style>
            @endonce

            <span class="inline-flex text-[12px] mt-4 items-center gap-2 {{ $hint }}">
    <span class="relative inline-flex items-center justify-center">
        <!-- minimal ring (very subtle) -->
        <span
            class="absolute -inset-1 rounded-full"
            style="background: rgba(16,185,129,.35); filter: blur(6px); animation: soft-ring 2.6s ease-in-out infinite;"
        ></span>

        <!-- icon pulse -->
        <i
            class="fa-solid fa-lock relative z-10 text-emerald-600 text-[13px]"
            style="animation: soft-pop 2.6s ease-in-out infinite;"
        ></i>
    </span>

    {{ __('forms.consultation.privacy') }}
</span>




        </div>

        <!-- RIGHT -->
        <div class="flex-1 space-y-3">

            <!-- Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                <!-- Full name -->
                <div>
                    <label class="block text-[10px] tracking-[0.18em] uppercase mb-1 {{ $label }}">
                        {{ __('forms.consultation.fields.name') }}
                    </label>
                    <x-input
                        type="text"
                        wire:model.live="name"
                        name="name"
                        :class="$field"
                        :placeholder="__('forms.consultation.placeholders.name')"
                        autocomplete="name"
                        :class="$field.' '.($errors->has('name') ? $invalid : '')"
                    />
                    @error('name') <p class="mt-1 text-[12px] {{ $errorText }}">{{ $message }}</p> @enderror

                </div>

                <!-- Phone -->
                <div class="space-y-1.5">
                    <label class="block text-[10px] tracking-[0.18em] uppercase mb-1 {{ $label }}">
                        {{ __('forms.consultation.fields.phone') }}
                    </label>

                    @php($phoneId = 'phone-'.$this->getId())

                    <div wire:ignore class="w-full block"
                         data-react-phone
                         data-input-id="{{ $phoneId }}"
                         data-hidden-target="{{ $phoneId }}_hidden"
                         data-theme="{{ $isDark ? 'dark' : 'light' }}"
                         data-placeholder="{{ __('forms.consultation.placeholders.phone') }}"
                         data-search-placeholder="{{ __('forms.consultation.country_search') }}"
                         data-country-label="{{ __('forms.consultation.country_label') }}"
                         data-invalid-text="{{ __('validation.custom.phone.valid_phone') }}">
                    </div>

                    <input type="hidden" id="{{ $phoneId }}_hidden" wire:model.live="phone">

                    @error('phone')
                    <p class="mt-1 text-[12px] {{ $errorText }}">{{ $message }}</p>
                    @enderror
                </div>






                <!-- Email -->
                <div>
                    <label class="block text-[10px] tracking-[0.18em] uppercase mb-1 {{ $label }}">
                        {{ __('forms.consultation.fields.email') }}
                    </label>
                    <x-input
                        type="email"
                        wire:model.live="email"
                        name="email"
                        :class="$field.' '.($errors->has('email') ? $invalid : '')"
                        :placeholder="__('forms.consultation.placeholders.email')"
                        autocomplete="email"
                    />
                    @error('email') <p class="mt-1 text-[12px] {{ $errorText }}">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Row 2 -->
            <div class="flex flex-col md:flex-row md:items-end gap-3">

                <!-- Message -->
                <div class="flex-1 -mb-[6.3px]">
                    <label class="block text-[10px] tracking-[0.18em] uppercase mb-1 {{ $label }}">
                        {{ __('forms.consultation.fields.message') }}
                    </label>
                    <x-textarea
                        rows="1"
                        wire:model.live="message"
                        :placeholder="__('forms.consultation.placeholders.message')"
                        :class="'rounded-xl px-3.5 py-2.5 text-[14px] resize-none mb-3 sm:mb-0 min-h-[4.2rem] sm:min-h-[1.6rem] '.$field"
                    />
                    @error('message') <p class="mt-1 text-[12px] {{ $errorText }}">{{ $message }}</p> @enderror
                </div>

                <!-- Submit -->
                <x-button
                    type="submit"
                    variant="primary"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove wire:target="submit">{{ __('forms.consultation.cta.submit') }}</span>
                    <span wire:loading wire:target="submit">{{ __('forms.consultation.cta.submitting') }}</span>
                </x-button>
            </div>

        </div>
    </form>


</div>
















