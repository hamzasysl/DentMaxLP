<div x-data="{ open:false, image:null }">
    <div class="relative  lg:mt-10">

        <!-- Desktop badge -->
        <a href="/{{ request()->segment(1) }}/{{ request()->segment(2) }}/gallery" wire:navigate
           class="flex absolute -top-8  -left-2 md:-left-5 z-30">
            <div class="h-17 w-17 rounded-full bg-gradient-to-b from-brand-600 to-brand-400
                    flex flex-col items-center justify-center text-[10px] font-semibold
                    tracking-[0.02em] text-white leading-tight text-center">
                {{__('front.before-after.view-all-smileys')}}
            </div>
        </a>

        <!-- Slider -->
        <div class="relative overflow-hidden ">
            <div class="pointer-events-none    xl:block absolute  right-0 sm:lg:-right-10  xl:right-7 2xl:right-12 top-0 bottom-0
                        w-32 sm:w-62 bg-gradient-to-l from-white via-white/90 to-transparent z-20"></div>

            <div id="casesSlider"
                 class="overflow-x-auto no-scrollbar scroll-smooth
                        cursor-grab active:cursor-grabbing select-none">
                <div class="flex gap-4 md:gap-6 pr-4 md:pr-32">
                    @foreach($cases as $case)
                        <article class="shrink-0 basis-1/2 md:basis-[325px] md:w-[325px] snap-start">
                            <div class="rounded-xl border border-main-200 overflow-hidden bg-white">
                                <img
                                    src="{{ asset($case['image']) }}"
                                    class="h-73 sm:h-105 lg:h-107 w-full object-cover cursor-pointer"
                                    alt="Smile case"
                                    loading="lazy"
                                    @click="image='{{ asset($case['image']) }}'; open=true"
                                >
                            </div>

                            @if(!empty($case['caption']))
                                <p class="text-[12px] text-main-500 mt-3 leading-relaxed">
                                    {{ $case['caption'] }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- LIGHTBOX -->
    <div
        x-show="open"
        x-transition.opacity
        @keydown.escape.window="open=false"
        class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4"
        style="display:none;"
    >
        <!-- Image wrapper -->
        <div
            @click.outside="open=false"
            class="relative max-w-[92vw] max-h-[88vh] overflow-hidden rounded-2xl bg-white
                   shadow-[0_30px_80px_rgba(0,0,0,0.35)]"
        >
            <!-- Close INSIDE image -->
            <button
                type="button"
                @click="open=false"
                class="absolute top-3 right-3 z-20 inline-flex h-9 w-9 items-center justify-center
                       rounded-full bg-black/60 text-white text-xl font-light
                       hover:bg-black/80 cursor-pointer transition"
                aria-label="Close"
            >
                <span class="leading-none translate-y-[-1px] select-none">×</span>
            </button>

            <img
                :src="image"
                class="max-h-[88vh] w-auto object-contain"
                alt="Smile case preview"
            >
        </div>
    </div>
</div>
