{{-- Ön değerlendirme — Zürih LP'deki kart düzeni (solda fotoğraf, sağda 3 adımlı form) --}}
<div class="w-full" data-step-form-root>
    <div class="mx-auto w-full max-w-6xl">
        <div class="relative overflow-visible rounded-[22px] p-[1px] shadow-[0_30px_70px_-34px_rgba(0,38,23,.3)]">

            {{-- hareketli çerçeve --}}
            <div class="step-brand-shimmer pointer-events-none absolute -inset-[1px] rounded-[23px] opacity-70"></div>

            {{-- tek parça kart: solda fotoğraf, sağda form --}}
            <div class="relative z-10 grid overflow-hidden rounded-[22px] bg-white ring-1 ring-black/5 lg:grid-cols-12">

                {{-- SOL: fotoğraf paneli --}}
                <div wire:ignore class="relative hidden overflow-hidden lg:col-span-5 lg:block">
                    <img src="{{ asset('img/lp/invisalign/step-aligner.webp') }}" alt="Şeffaf plağını takan hasta" loading="lazy"
                         class="pointer-events-none absolute inset-0 h-full w-full max-w-none object-cover object-[45%_50%] select-none">
                    <div class="absolute inset-0 bg-gradient-to-t from-brand-900/75 via-brand-900/0 to-transparent"></div>
                    <div class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-white/25 to-transparent"></div>

                    <p class="absolute inset-x-6 bottom-6 flex items-center gap-2.5 text-[11px] font-semibold uppercase tracking-[0.24em] text-white/85">
                        <span class="h-px w-6 bg-[#e2b979]"></span> {{ config('brand.name') }}
                    </p>
                </div>

                {{-- SAĞ: form — yükseklik değişimi animasyonlu --}}
                <div class="lg:col-span-7"
                     x-data="{
                        h: null, ro: null,
                        init() {
                            const el = this.$refs.inner;
                            this.h = el.offsetHeight;
                            this.ro = new ResizeObserver(() => { this.h = el.offsetHeight; });
                            this.ro.observe(el);
                        },
                        destroy() { this.ro?.disconnect(); }
                     }">
                    <div class="overflow-hidden transition-[height] duration-700 ease-[cubic-bezier(.22,1,.36,1)]"
                         :style="h !== null ? `height: ${h}px` : ''">
                        <div x-ref="inner" class="p-6 sm:p-10 lg:p-12">

                            {{-- başlık --}}
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-[12px] font-medium uppercase tracking-[0.08em] text-main-400 md:text-[14px]">{{ __('forms.consultation.quick-check') }}</p>
                                <span class="shrink-0 rounded-full bg-main-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-main-500">
                                    {{ __('front.global.step') }} {{ $step }} / 3
                                </span>
                            </div>

                            <h3 class="mt-4 text-[30px] font-extralight tracking-[-0.01em] text-main-900 md:mt-6 lg:text-[36px]">
                                {{ __('forms.consultation.free-dental-analysis') }}
                            </h3>

                            {{-- ilerleme --}}
                            <div class="mt-4 h-[3px] w-full rounded-full bg-main-100 md:mt-6">
                                <div class="h-[3px] rounded-full bg-gradient-to-r from-brand-900 via-brand-600 to-[#c9973f] transition-all duration-500"
                                     style="width: {{ $this->progress }}%"></div>
                            </div>

                            {{-- HATA --}}
                            @if($submitFailed)
                                <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-[13.5px] text-red-700">
                                    <p class="font-semibold">{{ __('forms.consultation.failed-to-receive') }}</p>
                                    <p class="mt-0.5">{{ __('forms.consultation.failed-to-receive-text') }}</p>
                                    @if($submitError)<p class="mt-1 font-mono text-[11px] break-all opacity-75">{{ $submitError }}</p>@endif
                                </div>
                            @endif

                            {{-- İÇERİK (adım değişince kayarak belirir) --}}
                            <div class="step-anim mt-6 md:mt-8" wire:key="step-content-{{ $step }}">

                                {{-- ADIM 1: kimin için --}}
                                @if($step === 1)
                                    <p class="text-[15px] font-light text-main-700">Tedaviyi kimin için düşünüyorsunuz?</p>

                                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                                        @foreach($patients as $value => $label)
                                            <button type="button" wire:click="setPatient('{{ $value }}')"
                                                    class="group cursor-pointer rounded-xl border px-4 py-3 text-left transition focus:ring-2 focus:ring-brand-400/40 focus:outline-none
                                                           {{ $patient === $value ? 'border-brand-400/70 bg-brand-50' : 'border-main-200 bg-white hover:border-brand-300' }}">
                                                <div class="flex items-center justify-between gap-4">
                                                    <div class="flex items-center gap-3">
                                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-brand-50 text-brand-700 transition group-hover:bg-brand-700 group-hover:text-white">
                                                            <i class="fa-solid {{ $value === 'child' ? 'fa-child' : 'fa-user' }} text-[13px]"></i>
                                                        </span>
                                                        <div>
                                                            <div class="text-[9.5px] uppercase tracking-[0.2em] text-main-400">Seçenek</div>
                                                            <div class="text-[14.5px] text-main-900">{{ $label }}</div>
                                                        </div>
                                                    </div>
                                                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full border text-[11px]
                                                                 {{ $patient === $value ? 'border-brand-400 bg-brand-100 text-brand-700' : 'border-main-200 bg-white text-main-300' }}">✓</span>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('patient') <div class="mt-3 text-sm text-red-600">{{ $message }}</div> @enderror
                                @endif

                                {{-- ADIM 2: gülüşteki durum --}}
                                @if($step === 2)
                                    <div class="flex items-center justify-between gap-4">
                                        <p class="text-[15px] font-light text-main-700">Gülüşünüze en çok benzeyen durumu seçin.</p>
                                        @if($condition)
                                            <span class="hidden shrink-0 text-[12px] text-main-500 sm:inline">{{ __('forms.consultation.selected') }}: <span class="font-medium text-main-900">{{ $conditions[$condition] }}</span></span>
                                        @endif
                                    </div>

                                    <div class="mt-5 grid grid-cols-2 gap-2 sm:grid-cols-4 sm:gap-3">
                                        @foreach($conditions as $key => $label)
                                            <button type="button" wire:click="setCondition('{{ $key }}')"
                                                    class="group flex cursor-pointer flex-col items-center gap-2 rounded-xl border px-2 pt-3 pb-2.5 text-center transition focus:ring-2 focus:ring-brand-400/40 focus:outline-none
                                                           {{ $condition === $key ? 'border-brand-400/70 bg-brand-50' : 'border-main-200 bg-white hover:border-brand-300 hover:bg-main-50/60' }}">
                                                <span aria-hidden="true"
                                                      class="block h-8 w-[78%] bg-current transition-colors sm:h-9 {{ $condition === $key ? 'text-brand-700' : 'text-main-600 group-hover:text-brand-700' }}"
                                                      style="-webkit-mask: url('{{ asset('img/invisalign/bite/' . $key . '.svg') }}') center / contain no-repeat; mask: url('{{ asset('img/invisalign/bite/' . $key . '.svg') }}') center / contain no-repeat;"></span>
                                                <span class="max-w-full truncate text-[12px] whitespace-nowrap text-main-700 sm:text-[12.5px]" title="{{ $label }}">{{ $label }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('condition') <div class="mt-3 text-sm text-red-600">{{ $message }}</div> @enderror
                                @endif

                                {{-- ADIM 3: iletişim --}}
                                @if($step === 3)
                                    @php
                                        $input = 'h-12 w-full rounded-xl border border-main-200 bg-white px-4 text-[15px] text-main-900 outline-none placeholder:text-main-300 focus:border-brand-400 focus:ring-4 focus:ring-brand-400/10';
                                        $lbl   = 'mb-2 block text-[11px] uppercase tracking-[0.24em] text-main-500';
                                        $phoneId = 'phone-' . $this->getId();
                                    @endphp
                                    <p class="text-[15px] font-light text-main-700">{{ __('forms.consultation.leave-your-details-text') }}</p>

                                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <label for="step-name-{{ $this->getId() }}" class="{{ $lbl }}">{{ __('forms.consultation.fields.name') }}</label>
                                            <input id="step-name-{{ $this->getId() }}" type="text" wire:model.blur="name" autocomplete="name"
                                                   placeholder="{{ __('forms.consultation.placeholders.name') }}" class="{{ $input }} @error('name') !border-red-400 @enderror">
                                            @error('name') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                                        </div>

                                        <div>
                                            <label for="{{ $phoneId }}" class="{{ $lbl }}">{{ __('forms.consultation.fields.phone') }}</label>
                                            <div wire:ignore class="block w-full"
                                                 data-react-phone
                                                 data-input-id="{{ $phoneId }}"
                                                 data-hidden-target="{{ $phoneId }}_hidden"
                                                 data-theme="light"
                                                 data-shell-class="min-h-[48px]"
                                                 data-placeholder="{{ __('forms.consultation.placeholders.phone') }}"
                                                 data-search-placeholder="{{ __('forms.consultation.country_search') }}"
                                                 data-country-label="{{ __('forms.consultation.country_label') }}"
                                                 data-invalid-text="{{ __('validation.custom.phone.valid_phone') }}">
                                            </div>
                                            <input type="hidden" id="{{ $phoneId }}_hidden" wire:model="phone">
                                            @error('phone') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                                        </div>

                                        <div>
                                            <label for="step-email-{{ $this->getId() }}" class="{{ $lbl }}">{{ __('forms.consultation.fields.email') }}</label>
                                            <input id="step-email-{{ $this->getId() }}" type="email" wire:model.blur="email" autocomplete="email" inputmode="email"
                                                   placeholder="{{ __('forms.consultation.placeholders.email') }}" class="{{ $input }} @error('email') !border-red-400 @enderror">
                                            @error('email') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="flex cursor-pointer items-start gap-3 text-[12.5px] leading-relaxed text-main-500">
                                                <input type="checkbox" wire:model="kvkk" class="mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded border-main-300 accent-brand-600">
                                                <span>
                                                    {!! __('forms.consultation.dm-kvkk', [
                                                        'link' => '<a href="#kvkk" class="font-medium text-brand-700 underline underline-offset-2 hover:text-brand-800">' . e(__('forms.consultation.dm-kvkk-link')) . '</a>',
                                                    ]) !!}
                                                </span>
                                            </label>
                                            @error('kvkk') <div class="mt-2 text-sm text-red-600">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="flex items-center gap-2 text-[12px] text-main-500 sm:col-span-2">
                                            <i class="fa-solid fa-lock text-[12px] text-[#c9973f]"></i> {{ __('forms.consultation.privacy') }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- aksiyonlar --}}
                            <div class="mt-8 flex items-center justify-between gap-4 border-t border-main-200/70 pt-5">
                                <button type="button" wire:click="prevStep"
                                    @class([
                                        'inline-flex h-10 cursor-pointer items-center gap-2 rounded-full border border-main-200 px-5 text-[11.5px] font-semibold uppercase tracking-[0.14em] text-main-700 transition hover:border-main-300 hover:bg-white',
                                        'pointer-events-none opacity-40' => $step === 1,
                                    ])>
                                    <span class="text-brand-600">‹</span> {{ __('front.global.prev') }}
                                </button>

                                @if($step < 3)
                                    <button type="button" wire:click="nextStep"
                                            class="btn-accent inline-flex h-10 cursor-pointer items-center gap-1.5 rounded-full px-6 text-[11.5px] font-semibold uppercase tracking-[0.14em]">
                                        {{ __('front.global.next') }} <span class="text-white/90">›</span>
                                    </button>
                                @else
                                    <button type="button" wire:click="submit" wire:loading.attr="disabled" wire:target="submit"
                                            class="btn-accent inline-flex h-10 cursor-pointer items-center gap-1.5 rounded-full px-6 text-[11.5px] font-semibold uppercase tracking-[0.14em] disabled:cursor-wait disabled:opacity-70">
                                        <span wire:loading.remove wire:target="submit">Analizimi gönder <span class="text-white/90">→</span></span>
                                        <span wire:loading wire:target="submit"><i class="fa-solid fa-circle-notch fa-spin text-[11px]"></i> {{ __('forms.consultation.cta.submitting') }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
