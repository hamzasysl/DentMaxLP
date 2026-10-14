@php
    $segments = request()->segments();
    $homeUrl  = url('/' . ($segments[0] ?? app()->getLocale()) . '/' . ($segments[1] ?? config('brand.default_lp')));
    $isBase   = count($segments) <= 2;
    $anchor   = fn (string $id) => $isBase ? "#{$id}" : "{$homeUrl}#{$id}";

    $links = [
        'vakalar'     => 'Invisalign',
        'tedavi-sureci' => 'Tedavi süreci',
        'hekim'       => 'Hakkımda',
        'yorumlar'    => 'Yorumlar',
        'sss'         => 'SSS',
    ];

    $social = array_filter(config('brand.social'));
    $icons  = ['instagram' => 'fa-instagram', 'facebook' => 'fa-facebook-f', 'youtube' => 'fa-youtube', 'tiktok' => 'fa-tiktok', 'linkedin' => 'fa-linkedin-in'];
    $wa     = \App\Support\WhatsApp::url();
    $label  = 'text-[11px] font-medium uppercase tracking-[0.24em] text-white/45';
@endphp

<footer id="iletisim" class="relative isolate overflow-hidden bg-brand-900 text-white">
    <x-logo-mark class="pointer-events-none absolute -right-24 -bottom-16 -z-10 hidden h-[480px] w-auto select-none md:block"
                 style="--logo-ink: #ffffff; --logo-accent: #ffffff; opacity: .04;" />
    <div aria-hidden="true" class="absolute inset-0 -z-10 bg-[radial-gradient(55%_80%_at_0%_0%,rgba(68,105,179,.35),transparent_65%),radial-gradient(45%_70%_at_100%_100%,rgba(148,176,226,.12),transparent_65%)]"></div>

    <div class="mx-auto max-w-site px-5 pt-16 pb-28 lg:px-8 lg:pt-20 lg:pb-8">

        {{-- Üst: marka + linkler + şubeler --}}
        <div class="grid gap-12 lg:grid-cols-[1.25fr_.8fr_1fr_1fr] lg:gap-10">

            {{-- Marka --}}
            <div class="max-w-sm">
                <x-logo tone="light" class="text-[21px]" />
                <p class="mt-6 text-[14.5px] leading-relaxed text-white/60">{{ __('front.footer.footer-text') }}</p>

                <div class="mt-7 flex flex-wrap items-center gap-2.5">
                    <a href="{{ $wa }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2.5 text-[13px] font-medium text-brand-900 transition hover:bg-brand-50">
                        <i class="fa-brands fa-whatsapp text-[16px] text-[#22c35e]"></i> WhatsApp
                    </a>
                    <a href="tel:{{ $phoneLink ?? '+' . preg_replace('/\D+/', '', config('brand.contact.phone_link')) }}"
                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-4 py-2.5 text-[13px] font-medium text-white transition hover:border-white/40 hover:bg-white/5">
                        <i class="fa-solid fa-phone text-[12px] text-brand-300"></i> {{ config('brand.contact.phone_text') }}
                    </a>
                </div>

                @if(config('brand.google_reviews_url'))
                    <a href="{{ config('brand.google_reviews_url') }}" target="_blank" rel="noopener"
                       class="mt-5 inline-flex items-center gap-2.5 text-[13px] text-white/60 transition hover:text-white">
                        <span class="flex gap-0.5 text-[11px] text-[#e2b979]">@for($s = 0; $s < 5; $s++)<i class="fa-solid fa-star"></i>@endfor</span>
                        <span><span class="font-semibold text-white">5.0</span> Google puanı</span>
                    </a>
                @endif

                @if($social)
                    <div class="mt-6 flex gap-2">
                        @foreach($social as $key => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($key) }}"
                               class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-white/15 text-white/70 transition hover:border-white/40 hover:text-white">
                                <i class="fa-brands {{ $icons[$key] ?? 'fa-link' }} text-[14px]"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Sayfa linkleri --}}
            <nav aria-label="Sayfa içi bağlantılar">
                <p class="{{ $label }}">Hızlı erişim</p>
                <ul class="mt-5 space-y-3">
                    @foreach($links as $id => $text)
                        <li>
                            <a href="{{ $anchor($id) }}" class="group inline-flex items-center gap-2 text-[14px] text-white/70 transition hover:text-white">
                                <span class="h-px w-0 bg-[#e2b979] transition-all duration-300 group-hover:w-3"></span>{{ $text }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            {{-- Şubeler --}}
            @foreach(config('brand.branches') as $b)
                <div>
                    <p class="{{ $label }}">{{ $b['name'] }}</p>
                    <address class="mt-5 text-[14px] leading-relaxed not-italic text-white/70">{{ $b['address'] }}</address>
                    <a href="tel:+{{ preg_replace('/\D+/', '', $b['phone_link']) }}"
                       class="mt-4 inline-flex items-center gap-2 text-[15px] font-medium text-white transition hover:text-brand-200">
                        <i class="fa-solid fa-phone text-[11px] text-brand-300"></i>{{ $b['phone_text'] }}
                    </a>
                    <dl class="mt-4 space-y-1.5 text-[13px]">
                        @foreach($b['hours'] as $day => $time)
                            <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-1.5 last:border-0">
                                <dt class="text-white/50">{{ $day }}</dt>
                                <dd class="text-white/80">{{ $time }}</dd>
                            </div>
                        @endforeach
                    </dl>
                    @if(!empty($b['maps_link']))
                        <a href="{{ $b['maps_link'] }}" target="_blank" rel="noopener"
                           class="mt-4 inline-flex items-center gap-2 text-[13px] text-white/60 transition hover:text-white">
                            <i class="fa-solid fa-diamond-turn-right text-[12px] text-[#e2b979]"></i> Yol tarifi al
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Alt bar --}}
        <div id="footer-bottom" class="mt-14 flex flex-col gap-4 border-t border-white/10 pt-6 lg:mt-16 text-[12.5px] text-white/45 lg:flex-row lg:items-center lg:justify-between">
            <p>© {{ date('Y') }} {{ config('brand.name') }}. {{ __('front.footer.copyright') }}</p>
            <p class="max-w-xl lg:text-center"><span lang="en">Invisalign®</span>, <span lang="en">Align Technology, Inc.</span>’in tescilli markasıdır.</p>
            <div class="flex items-center gap-5">
                <a href="#kvkk" class="transition hover:text-white">{{ __('front.footer.copyright-kvkk') }}</a>
                <a href="https://mezbilisim.com" target="_blank" rel="noopener" class="transition hover:text-white"><span lang="en">Code with</span> <span class="font-semibold text-white/70">MEZ</span></a>
            </div>
        </div>
    </div>
</footer>
