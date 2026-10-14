<div
    data-luckyspin-modal
    x-data="{ open: false }"
    x-cloak
    x-effect="document.body.classList.toggle('overflow-hidden', open)"
    @open-luckyspin.window="open = true"
    @close-luckyspin.window="open = false"
    @keydown.escape.window="open = false"
>
    {{-- BACKDROP --}}
    <div
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 z-[9998] bg-black/55 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- WRAPPER (panel dışına tıklayınca kapanır) --}}
    <div
        x-show="open"
        x-transition
        class="fixed inset-0 z-[99999] flex items-center justify-center
           px-3 sm:px-5 py-4 sm:py-5 overflow-y-auto"
        role="dialog"
        aria-modal="true"
        @click="open = false"
    >
        {{-- PANEL --}}
        <div
            class="relative w-full max-w-7xl rounded-3xl overflow-auto
           shadow-[0_30px_90px_rgba(0,0,0,0.32)]
           max-h-[calc(100svh-2rem)] sm:max-h-none"
            @click.stop
        >
            {{-- CLOSE (sağ üst) --}}
            <button
                type="button"
                class="absolute top-5 right-6 z-50 h-9.5 w-9.5 inline-flex items-center justify-center
                       rounded-full border  bg-white/85 text-gray-700 border-1 border-gray-200
                       backdrop-blur hover:bg-gray-50 hover:border-brand-200 hover:text-brand-700 cursor-pointer"
                @click="open = false"
                aria-label="Close"
            >
                ✕
            </button>

            {{-- CONTENT SECTION (senin section style) --}}
            <section class="relative overflow-hidden bg-gradient-to-b from-gray-50 via-white to-gray-100">
                {{-- soft copper line (üst) --}}
                <div class="pointer-events-none absolute -left-40 top-20 h-px w-[120%] rotate-[-8deg]
                    bg-gradient-to-r from-transparent via-brand-400/45 to-transparent"></div>

                {{-- soft copper line (alt) --}}
                <div class="pointer-events-none absolute -left-40 bottom-24 h-px w-[120%] rotate-[6deg]
                    bg-gradient-to-r from-transparent via-brand-400/25 to-transparent"></div>

                {{-- subtle glow blobs --}}
                <div class="pointer-events-none absolute -top-32 left-1/2 h-[420px] w-[420px] -translate-x-1/2 rounded-full
                    bg-brand-400/10 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-40 -right-32 h-[520px] w-[520px] rounded-full
                    bg-main-900/5 blur-3xl"></div>

                {{-- spin bg image (sağ alt sabit) --}}
                <img
                    src="{{ asset('img/spin-bg-bottom.png') }}"
                    style="filter: brightness(0.65);"
                    alt=""
                    class="pointer-events-none absolute bottom-0 right-0 w-[520px] max-w-none opacity-90
                           translate-y-10 md:translate-y-16 lg:w-[680px]"
                />

                {{-- inner padding --}}
                <div class="relative z-10 mx-auto max-w-screen-2xl px-5 sm:px-7 lg:px-10 py-8 lg:py-12">
                    {{-- küçük üst başlık (opsiyonel) --}}
                    <div class="mb-6 flex items-center gap-3">
                        <span class="h-px w-10 bg-gradient-to-r from-transparent via-brand-400/70 to-transparent"></span>
                        <span class="text-[11px] uppercase tracking-[0.26em] text-main-500">
                            {{ __('forms.lucky-spin.name') }}
                        </span>
                    </div>

                    {{-- LuckySpin --}}
                    <livewire:ui.forms.lucky-spin />
                </div>
            </section>
        </div>
    </div>
</div>
