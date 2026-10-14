<meta name="disable-exit-modal" content="1">

<div class="bg-white">
    {{-- Top ambient --}}
    <div class="relative overflow-hidden">
        <div class="pointer-events-none absolute -top-56 -right-56 h-[680px] w-[680px] rounded-full bg-brand-200/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-72 -left-72 h-[820px] w-[820px] rounded-full bg-main-900/5 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-40 top-24 h-px w-[140%] rotate-[-8deg]
            bg-gradient-to-r from-transparent via-brand-400/35 to-transparent"></div>

        <section class="relative pt-48 pb-34 lg:pt-54 lg:pb-38">
            <div class="mx-auto max-w-site px-5 lg:px-8">

                {{-- 2 KOLON: SOL (HEADING DÜZ) + SAĞ (DETAILS CARD) --}}
                <div class="grid gap-10 lg:grid-cols-12 lg:gap-12 items-center">

                    {{-- LEFT: THANK YOU (NO CARD) --}}
                    <div class="lg:col-span-5 flex flex-col items-center text-center lg:items-start lg:text-left">
                        <p class="text-[11px] font-medium tracking-[0.34em] uppercase text-main-400">
                            {{ $lpName ?? config('brand.name') }}
                        </p>

                        <h1 class="mt-3 text-4xl sm:text-5xl -ml-2 lg:text-6xl font-extralight text-main-900 tracking-[0.006em] leading-[1.15]">
                            {{ __('front.ty.thanks') }}
                            <span class="block mt-2 text-main-700 ml-2 text-xl sm:text-2xl lg:text-3xl font-extralight">
                                 {{ __('front.ty.successfully-submitted') }}
                            </span>
                        </h1>

                        <div class="mt-6 h-[1.5px] w-24 rounded-full bg-brand-500/80"></div>

                        <p class="mt-5 text-[14px] sm:text-[15px] font-light text-main-600 leading-relaxed max-w-md">
                            {{ __('front.ty.successfully-message') }}
                        </p>

                        {{-- GO HOME (pill button) --}}
                        @php
                            $segments = request()->segments();
                            $target = '/' . ($segments[0] ?? app()->getLocale()) . '/' . ($lpSlug ?? ($segments[1] ?? config('brand.default_lp')));
                        @endphp

                        <a
                            href="{{ url($target) }}"
                            wire:navigate
                            class="mt-10 group inline-flex items-center gap-2 lg:gap-3 rounded-2xl
                                   border border-main-200
                                   bg-white/70 backdrop-blur
                                   px-3 lg:px-4 py-1.5 w-fit
                                   text-[12px] md:text-[13px]
                                   text-main-700
                                   shadow-[0_10px_30px_rgba(0,0,0,0.05)]
                                   hover:bg-white/90 transition"
                        >
                            {{-- micro indicator --}}
                            <span class="inline-flex items-center justify-center
                                         -ml-1
                                         h-6 w-6
                                         rounded-full
                                         border border-white/10
                                         bg-white/10">
                                <span class="relative h-1.5 w-1.5">
                                    <span class="absolute inset-0 rounded-full bg-brand-400/60 animate-ping"></span>
                                    <span class="absolute -inset-1 rounded-full bg-brand-400/25 blur-sm"></span>
                                    <span class="absolute inset-0 rounded-full bg-brand-500"></span>
                                </span>
                            </span>

                            {{-- text --}}
                            <span class="font-light tracking-wide">
                                {{ __('front.global.go-home') }}
                            </span>

                            {{-- arrow --}}
                            <i class="fa-solid fa-arrow-left text-[11px] lg:text-[12px] opacity-40 mr-1 group-hover:opacity-55 transition"></i>
                        </a>
                    </div>

                    {{-- RIGHT: DETAILS CARD (details yapısını kullan) --}}
                    <div class="lg:col-span-7">
                        <div class="relative overflow-hidden rounded-[28px] border border-main-200 bg-white/70 p-6 lg:p-8
                                    shadow-[0_18px_50px_rgba(0,0,0,0.08)]">
                            <div class="pointer-events-none absolute -top-28 -right-24 h-72 w-72 rounded-full bg-brand-200/35 blur-3xl"></div>
                            <div class="pointer-events-none absolute -bottom-32 -left-28 h-80 w-80 rounded-full bg-brand-300/20 blur-3xl"></div>

                            <div class="flex items-end justify-between gap-4">
                                <div>
                                    <p class="text-[12px] md:text-[13px] font-medium tracking-[0.28em] uppercase text-main-500">
                                        {{ __('front.ty.details') }}
                                    </p>
                                    <h2 class="mt-2 text-2xl sm:text-3xl font-extralight text-main-900">
                                        {{ __('front.ty.application-summary') }}
                                    </h2>
                                </div>

                                <span
                                    id="localTime"
                                    class="inline-flex items-center rounded-full border border-main-200 bg-white/80 px-4 py-2
         text-[11px] uppercase tracking-[0.22em] text-main-700"
                                >
                                    {{ now()->format('d.m.Y H:i') }}
                                </span>
                            </div>

                            <div class="mt-6 h-px w-full bg-main-200/70"></div>

                            @php
                                $data = $thankYouData ?? [];

                                // ✅ REF HİÇ GÖSTERME
                                unset($data['ref'], $data['Ref'], $data['REF']);
                                unset(
    $data['source'],
    $data['Source'],
    $data['SOURCE'],
    $data['form'],
    $data['form_type'],
    $data['formType']
);

                                // Contact alanları (üstte)
                                $contactKeys = ['name','full_name','phone','phone_e164','email','message','notes'];
                                $contact = [];
                                foreach ($contactKeys as $k) {
                                    if (isset($data[$k]) && trim((string)$data[$k]) !== '') {
                                        $contact[$k] = $data[$k];
                                    }
                                }

                                // DETAILS: mail template mantığı
                                $details = $data['details'] ?? [];
                                if (is_string($details)) {
                                    $decoded = json_decode($details, true);
                                    $details = (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) ? $decoded : [];
                                }
                                if (!is_array($details)) $details = [];

                                // 👇 buraya ekle
                                   unset(
                                       $details['source'], $details['Source'], $details['SOURCE'],
                                  $details['form'], $details['Form'], $details['FORM'],
                                  $details['form_type'], $details['formType']
                                    );

                                // ✅ details içinde de ref varsa kaldır
                                foreach (['ref','Ref','REF'] as $rk) {
                                    if (isset($details[$rk])) unset($details[$rk]);
                                }

                                // label humanize
                                $label = function(string $key): string {
                                    return strtoupper(str_replace(['_','-'], ' ', $key));
                                };

                                $formatValue = function($v): string {
                                    if (is_array($v)) return implode(', ', array_map('strval', $v));
                                    return trim((string)$v);
                                };
                            @endphp

                            {{-- CONTACT (grid) --}}
                            @if(!empty($contact))
                                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                                    @foreach($contact as $k => $v)
                                        @php $fv = $formatValue($v); @endphp
                                        @if($fv !== '')
                                            <div class="rounded-2xl border border-main-200/70 bg-white/80 p-5">
                                                <dt class="text-[12px] md:text-[13px] font-medium tracking-[0.26em] uppercase text-main-600">
                                                    {{ $label((string)$k) }}
                                                </dt>
                                                <dd class="mt-2 text-[15px] font-light text-main-900 break-words">
                                                    {{ $fv }}
                                                </dd>
                                            </div>
                                        @endif
                                    @endforeach
                                </dl>
                            @endif

                            {{-- DETAILS (gender, tooth model, discount...) --}}
                            @if(!empty($details))
                                <div class="mt-8">
                                    <div class="flex items-center justify-between">
                                        <p class="text-[12px] md:text-[13px] font-medium tracking-[0.28em] uppercase text-main-500">
                                              {{ __('front.ty.additional-information') }}
                                        </p>
                                    </div>

                                    <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                        @foreach($details as $k => $v)
                                            @php $fv = $formatValue($v); @endphp
                                            @if($fv !== '')
                                                <div class="rounded-2xl border border-main-200/70 bg-white/80 p-5">
                                                    <dt class="text-[12px] md:text-[13px] font-medium tracking-[0.26em] uppercase text-main-600">
                                                        {{ $label((string)$k) }}
                                                    </dt>
                                                    <dd class="mt-2 text-[15px] font-light uppercase text-main-900 break-words">
                                                        {{ $fv }}
                                                    </dd>
                                                </div>
                                            @endif
                                        @endforeach
                                    </dl>
                                </div>
                            @endif

                            @if(empty($contact) && empty($details))
                                <div class="mt-6 rounded-2xl border border-main-200 bg-white/80 p-5 text-main-700">
                                    <p class="text-[12.5px] font-light">
                                        {{ __('front.ty.visible-details') }}
                                    </p>
                                </div>
                            @endif

                            <p class="mt-6 text-[12px] font-light text-main-500 leading-relaxed">
                                {{ __('front.ty.application-info') }}
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>
</div>

@once
    @push('scripts')

        <script>
            (function () {
                const el = document.getElementById('localTime');
                if (!el) return;
                const d = new Date();
                const pad = (n) => String(n).padStart(2, '0');
                el.textContent = `${pad(d.getDate())}.${pad(d.getMonth()+1)}.${d.getFullYear()} - ${pad(d.getHours())}:${pad(d.getMinutes())}`;
            })();
        </script>

    @endpush
@endonce
