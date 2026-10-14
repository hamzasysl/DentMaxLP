{{-- Lead formu — açık zemin, minimum alan (ad, telefon, durum, KVKK)
     layout="lead"        : dikey (modal)
     layout="lead-inline" : alanlar tek satırda (sayfa içi teklif kartı)
     layout="lead-compact": ad + telefon yan yana, durum altta (hero)
     layout="lead-band"   : koyu bant, alanlar + buton tek satırda (sayfa içi yatay form) --}}
@php
    $inline  = ($layout ?? '') === 'lead-inline';
    $compact = ($layout ?? '') === 'lead-compact';
    $band    = ($layout ?? '') === 'lead-band';
    $field   = $band
        ? 'h-10 w-full rounded-lg border border-white/15 bg-white/[0.06] px-3.5 text-[16px] text-white placeholder:text-white/50 transition focus:border-brand-300 focus:outline-none focus:ring-4 focus:ring-brand-300/15'
        : 'h-12 w-full rounded-xl border border-main-200 bg-white px-4 text-[15px] text-main-900 placeholder:text-main-300 transition focus:border-brand-500 focus:outline-none focus:ring-4 focus:ring-brand-500/10';
    $label   = $band ? 'mb-1.5 block text-[11px] font-medium uppercase tracking-[0.18em] text-white/55' : ($inline ? 'sr-only' : ($compact ? 'mb-1 block text-[12.5px] font-medium text-main-600' : 'mb-1.5 block text-[13px] font-medium text-main-600'));
    $err     = $band ? 'mt-1.5 text-[12.5px] text-red-300' : 'mt-1.5 text-[12.5px] text-red-600';
    $phoneId = 'phone-' . $formKey;
@endphp

<form wire:submit.prevent="submit" class="relative {{ $compact ? 'space-y-3' : 'space-y-4' }}" novalidate>

    {{-- Honeypot --}}
    <input type="text" wire:model="company" class="hidden" tabindex="-1" autocomplete="off">

    {{-- HATA --}}
    @if($submitFailed)
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-[13.5px] text-red-700">
            <p class="font-semibold">{{ __('forms.consultation.failed-to-receive') }}</p>
            <p class="mt-0.5">{{ __('forms.consultation.failed-to-receive-text') }}</p>
            @if($submitError)<p class="mt-1 font-mono text-[11px] break-all opacity-75">{{ $submitError }}</p>@endif
        </div>
    @endif

    <div class="{{ $band ? 'grid gap-x-3 gap-y-3.5 sm:grid-cols-2 lg:grid-cols-3 lg:items-start' : ($inline ? 'grid gap-3 sm:grid-cols-2 lg:grid-cols-4' : ($compact ? 'grid gap-3 sm:grid-cols-2' : 'space-y-4')) }}">
    {{-- Ad Soyad --}}
    <div>
        <label for="name-{{ $formKey }}" class="{{ $label }}">{{ __('forms.consultation.fields.name') }}</label>
        <input id="name-{{ $formKey }}" type="text" wire:model.blur="name" autocomplete="name"
               placeholder="{{ __('forms.consultation.placeholders.name') }}"
               class="{{ $field }} @error('name') !border-red-400 @enderror">
        @error('name') <p class="{{ $err }}">{{ $message }}</p> @enderror
    </div>

    {{-- Telefon (React) --}}
    <div>
        <label for="{{ $phoneId }}" class="{{ $label }}">{{ __('forms.consultation.fields.phone') }}</label>
        <div wire:ignore class="block w-full"
             data-react-phone
             data-input-id="{{ $phoneId }}"
             data-hidden-target="{{ $phoneId }}_hidden"
             data-theme="{{ $band ? 'dark' : 'light' }}"
             data-shell-class="{{ $band ? '' : 'min-h-[48px]' }}"
             data-placeholder="{{ __('forms.consultation.placeholders.phone') }}"
             data-search-placeholder="{{ __('forms.consultation.country_search') }}"
             data-country-label="{{ __('forms.consultation.country_label') }}"
             data-invalid-text="{{ __('validation.custom.phone.valid_phone') }}">
        </div>
        <input type="hidden" id="{{ $phoneId }}_hidden" wire:model="phone">
        @error('phone') <p class="{{ $err }}">{{ $message }}</p> @enderror
    </div>

    {{-- E-posta --}}
    <div class="{{ $compact && ! $withTopic ? 'sm:col-span-2' : '' }}">
        <label for="email-{{ $formKey }}" class="{{ $label }}">{{ $emailRequired ? __('forms.consultation.fields.email') : __('forms.consultation.fields.email_optional') }}</label>
        <input id="email-{{ $formKey }}" type="email" wire:model.blur="email" autocomplete="email" inputmode="email"
               placeholder="{{ __('forms.consultation.placeholders.email') }}"
               class="{{ $field }} @error('email') !border-red-400 @enderror">
        @error('email') <p class="{{ $err }}">{{ $message }}</p> @enderror
    </div>

    {{-- İlgilenilen durum --}}
    @if(! $band && $withTopic)
    <div>
        <label for="topic-{{ $formKey }}" class="{{ $label }}">{{ __('forms.consultation.fields.topic') }}</label>
        <x-ui.select wire:model="topic" :options="$topics" id="topic-{{ $formKey }}"
                     :placeholder="__('forms.consultation.dm-topic-placeholder')" />
    </div>
    @endif

    @if($band)
        <div class="flex flex-col gap-3 sm:col-span-2 lg:col-span-3 lg:flex-row lg:items-end">
            <div class="min-w-0 flex-1">
                <label for="topic-{{ $formKey }}" class="{{ $label }}">{{ __('forms.consultation.fields.topic') }}</label>
                <x-ui.select wire:model="topic" :options="$topics" id="topic-{{ $formKey }}"
                             :placeholder="__('forms.consultation.dm-topic-placeholder')" dark />
            </div>
            <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                    class="group flex h-10 w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-white px-7 text-[12.5px] font-semibold uppercase tracking-[0.16em] whitespace-nowrap text-brand-900 shadow-[0_14px_30px_-14px_rgba(0,0,0,.6)] transition hover:bg-brand-50 disabled:cursor-wait disabled:opacity-70 lg:w-auto">
                <span wire:loading.remove wire:target="submit">Hemen gönder</span>
                <span wire:loading wire:target="submit">{{ __('forms.consultation.cta.submitting') }}</span>
                <i wire:loading.remove wire:target="submit" class="fa-solid fa-arrow-right text-[11px] transition group-hover:translate-x-0.5"></i>
            </button>
        </div>
    @endif
    </div>

    <div class="{{ $inline ? 'flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between lg:gap-8' : ($compact ? 'space-y-3' : 'space-y-4') }}">

    {{-- KVKK --}}
    @if($requireConsent)
        <div class="{{ $inline ? 'lg:max-w-xl' : '' }}">
            <label class="flex cursor-pointer items-start gap-3 text-[12.5px] leading-relaxed {{ $band ? 'text-white/55' : 'text-main-500' }}">
                <input type="checkbox" wire:model="kvkk"
                       class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded border-main-300 accent-brand-600">
                <span>
                    {!! __('forms.consultation.dm-kvkk', [
                        'link' => '<a href="#kvkk" class="font-medium ' . ($band ? 'text-white' : 'text-brand-700 hover:text-brand-800') . ' underline underline-offset-2">' . e(__('forms.consultation.dm-kvkk-link')) . '</a>',
                    ]) !!}
                </span>
            </label>
            @error('kvkk') <p class="{{ $err }}">{{ $message }}</p> @enderror
        </div>
    @endif

    {{-- Gönder --}}
    @unless($band)
    <button type="submit" wire:loading.attr="disabled" wire:target="submit"
            class="group relative flex {{ $inline ? 'w-full shrink-0 lg:w-auto' : 'w-full' }} btn-accent cursor-pointer items-center justify-center gap-2 rounded-xl px-5 py-3 text-[12.5px] font-semibold uppercase tracking-[0.14em] whitespace-nowrap disabled:cursor-wait disabled:opacity-70">
        <span wire:loading.remove wire:target="submit">{{ __('forms.consultation.dm-submit') }}</span>
        <span wire:loading wire:target="submit">{{ __('forms.consultation.cta.submitting') }}</span>
        <i wire:loading.remove wire:target="submit" class="fa-solid fa-arrow-right text-[12px] transition group-hover:translate-x-0.5"></i>
    </button>
    @endunless

    </div>

    @unless($inline || $compact || $band)
        <p class="flex items-center justify-center gap-2 text-[12px] text-main-400">
            <i class="fa-solid fa-lock text-[11px] text-brand-600"></i>
            {{ __('forms.consultation.privacy') }}
        </p>
    @endunless
</form>
