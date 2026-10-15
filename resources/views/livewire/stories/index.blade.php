{{-- Hasta hikayeleri listesi --}}
@php
    $iconMask = fn ($key) => "-webkit-mask: url('" . asset('img/invisalign/bite/' . $key . '.svg') . "') center / contain no-repeat; mask: url('" . asset('img/invisalign/bite/' . $key . '.svg') . "') center / contain no-repeat;";
@endphp

<div>
    <section class="relative isolate overflow-clip bg-ivory pt-28 pb-16 lg:pt-36 lg:pb-24">
        <x-mark-watermark class="-right-28 top-20 h-[460px]" />
        <div class="mx-auto max-w-site px-5 lg:px-8">
            <nav aria-label="Konum" class="flex items-center gap-2 text-[12.5px] text-main-400">
                <a href="{{ route('home') }}" class="transition hover:text-brand-700">Ana sayfa</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-main-600">Hasta hikayeleri</span>
            </nav>

            <div data-reveal class="mt-8 flex flex-col gap-5 lg:mt-10 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="flex items-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.3em] text-brand-600"><span class="h-px w-8 bg-[#c9973f]"></span>Hasta hikayeleri</p>
                    <h1 class="mt-4 text-[clamp(34px,4.2vw,56px)] leading-[1.08] tracking-[-0.025em] text-brand-900">
                        <span class="font-light">Başlangıçtan</span> <span class="font-semibold">Sonuca</span>
                    </h1>
                </div>
                <p class="max-w-md text-[16px] leading-relaxed text-main-500">Her hastamızın tedavisi farklı başlar. Hangi durumla geldiklerini, sürecin nasıl ilerlediğini ve sonucu kendi hikayelerinden okuyun.</p>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($stories as $story)
                    @php($after = $story['photos']['after'] ?? null)
                    <a data-reveal style="--d: {{ $loop->index * 70 }}ms" href="{{ route('stories.show', $story['slug']) }}"
                       class="group flex flex-col overflow-hidden rounded-[24px] bg-white ring-1 ring-main-200/70 transition duration-300 hover:-translate-y-1 hover:shadow-[0_30px_60px_-36px_rgba(38,28,22,.5)] hover:ring-brand-200">
                        <div class="relative aspect-[4/3] overflow-hidden bg-main-50">
                            @if($after)
                                <img src="{{ asset($after) }}" alt="{{ $story['name'] }} – tedavi sonrası" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
                            @else
                                <div aria-hidden="true" class="absolute inset-0 opacity-60 [background-image:radial-gradient(rgba(38,28,22,.09)_1px,transparent_1px)] [background-size:16px_16px]"></div>
                                <span aria-hidden="true" class="absolute inset-x-10 top-1/2 block aspect-[2.4] -translate-y-1/2 bg-current text-brand-700/70" style="{{ $iconMask($story['condition']) }}"></span>
                            @endif
                            <span class="absolute top-4 left-4 rounded-full bg-white/90 px-3 py-1 text-[11.5px] text-brand-800 ring-1 ring-main-200/70 backdrop-blur">{{ $story['condition_label'] }}</span>
                            @if(!empty($story['example']))
                                <span class="absolute top-4 right-4 rounded-full bg-[#fbf3e4] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.14em] text-[#8a5f22]">Örnek</span>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <h2 class="text-[20px] font-normal text-main-900">{{ $story['name'] }} <span class="font-light text-main-400">· {{ $story['age'] }} yaş</span></h2>
                            <p class="mt-2 line-clamp-2 text-[14.5px] leading-relaxed text-main-500">{{ $story['summary'] }}</p>
                            <div class="mt-5 flex items-center justify-between border-t border-main-100 pt-4 text-[13px]">
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
        </div>
    </section>
</div>
