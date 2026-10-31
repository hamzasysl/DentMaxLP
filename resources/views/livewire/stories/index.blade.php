{{-- Hasta hikayeleri listesi: başlık + durum filtresi + kartlar (+ sonda randevu kartı) --}}
@php
    $iconMask = fn ($key) => "-webkit-mask: url('" . asset('img/invisalign/bite/' . $key . '.svg') . "') center / contain no-repeat; mask: url('" . asset('img/invisalign/bite/' . $key . '.svg') . "') center / contain no-repeat;";
    $conditions = collect($stories)->pluck('condition_label', 'condition')->unique();
@endphp

<div x-data="{ filter: 'all' }">
    {{-- ============ BAŞLIK ============ --}}
    <section class="relative isolate overflow-clip bg-ivory pt-28 pb-12 lg:pt-36 lg:pb-14">
        <x-mark-watermark class="-right-24 top-16 h-[440px]" />
        <div class="mx-auto max-w-site px-5 lg:px-8">
            <nav aria-label="Konum" class="flex items-center gap-2 text-[12.5px] text-main-400">
                <a href="{{ route('home') }}" class="transition hover:text-brand-700">Ana sayfa</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-main-600">Hasta hikayeleri</span>
            </nav>

            <div data-reveal class="mt-8 max-w-3xl lg:mt-10">
                <p class="flex items-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.3em] text-brand-600"><span class="h-px w-8 bg-[#c9973f]"></span>Başlangıçtan sonuca</p>
                <h1 class="mt-4 text-[clamp(36px,4.6vw,60px)] leading-[1.06] tracking-[-0.025em] text-brand-900">
                    <span class="font-light">Hasta</span> <span class="font-semibold">Hikayeleri</span>
                </h1>
                <p class="mt-5 max-w-2xl text-[17px] leading-relaxed text-main-600">
                    Her hastamızın tedavisi farklı başlar. Hangi durumla geldiklerini, sürecin nasıl ilerlediğini ve sonucu kendi hikayelerinden okuyun.
                </p>
            </div>

            {{-- Durum filtresi --}}
            @if($conditions->count() > 1)
                <div data-reveal style="--d:80ms" class="mt-9 flex flex-wrap items-center gap-2">
                    <button type="button" @click="filter = 'all'"
                            :class="filter === 'all' ? 'bg-brand-900 text-white ring-brand-900' : 'bg-white text-main-700 ring-main-200 hover:ring-brand-300'"
                            class="cursor-pointer rounded-full px-4 py-2 text-[13.5px] ring-1 transition">Tümü <span class="ml-1 opacity-60">{{ count($stories) }}</span></button>
                    @foreach($conditions as $key => $label)
                        <button type="button" @click="filter = '{{ $key }}'"
                                :class="filter === '{{ $key }}' ? 'bg-brand-900 text-white ring-brand-900' : 'bg-white text-main-700 ring-main-200 hover:ring-brand-300'"
                                class="inline-flex cursor-pointer items-center gap-2 rounded-full py-2 pr-4 pl-3 text-[13.5px] ring-1 transition">
                            <span aria-hidden="true" class="block h-3 w-7 bg-current opacity-80" style="{{ $iconMask($key) }}"></span>{{ $label }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============ KARTLAR ============ --}}
    <section class="bg-white py-12 lg:py-16">
        <div class="mx-auto grid max-w-site gap-5 px-5 sm:grid-cols-2 lg:px-8 {{ count($stories) >= 3 ? 'lg:grid-cols-3' : '' }}">
            @foreach($stories as $story)
                @php($after = $story['photos']['after'] ?? null)
                <a x-show="filter === 'all' || filter === '{{ $story['condition'] }}'" x-transition.opacity
                   data-reveal style="--d: {{ $loop->index * 70 }}ms" href="{{ route('stories.show', $story['slug']) }}"
                   class="group flex flex-col overflow-hidden rounded-[24px] bg-white ring-1 ring-main-200/80 transition duration-300 hover:-translate-y-1 hover:shadow-[0_30px_60px_-36px_rgba(0,38,23,.5)] hover:ring-brand-200">
                    <div class="relative aspect-[4/3] overflow-hidden bg-ivory">
                        @if($after)
                            <img src="{{ asset($after) }}" alt="{{ $story['name'] }} – tedavi sonrası" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                        @else
                            <div aria-hidden="true" class="absolute inset-0 opacity-70 [background-image:radial-gradient(rgba(0,38,23,.08)_1px,transparent_1px)] [background-size:16px_16px]"></div>
                            <span aria-hidden="true" class="absolute inset-x-12 top-1/2 block aspect-[2.4] -translate-y-1/2 bg-current text-brand-600/70 transition duration-500 group-hover:scale-[1.04]" style="{{ $iconMask($story['condition']) }}"></span>
                        @endif
                        <span class="absolute top-4 left-4 rounded-full bg-white/90 px-3 py-1 text-[11.5px] text-brand-800 ring-1 ring-main-200/70 backdrop-blur">{{ $story['condition_label'] }}</span>
                        @if(!empty($story['example']))
                            <span class="absolute top-4 right-4 rounded-full bg-[#fbf3e4] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-[#8a5f22]">Örnek</span>
                        @endif
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <h2 class="text-[20px] font-normal text-main-900">{{ $story['name'] }} <span class="font-light text-main-400">· {{ $story['age'] }} yaş</span></h2>
                        <p class="mt-2 line-clamp-2 text-[14.5px] leading-relaxed text-main-500">{{ $story['summary'] }}</p>
                        <div class="mt-auto flex items-center justify-between border-t border-main-100 pt-4 text-[13px]">
                            <span class="flex gap-4 text-main-600">
                                <span><i class="fa-regular fa-clock mr-1.5 text-[11px] text-brand-600"></i>{{ $story['duration'] }}</span>
                                @if(!empty($story['aligners']))<span><i class="fa-solid fa-layer-group mr-1.5 text-[11px] text-brand-600"></i>{{ $story['aligners'] }} plak</span>@endif
                            </span>
                            <span class="inline-flex items-center gap-1.5 font-medium text-brand-700">Hikayeyi oku <i class="fa-solid fa-arrow-right text-[10px] transition group-hover:translate-x-0.5"></i></span>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </section>
</div>
