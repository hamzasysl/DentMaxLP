<div>
    <div
        class="space-y-4"
        x-data="{
            openIndex: (() => {
                const v = @js($openIndex ?? null);
                if (v === null || v === '' || typeof v === 'undefined') return null;
                const n = Number(v);
                return Number.isNaN(n) ? null : n;
            })(),
            toggle(i){
                i = Number(i);
                this.openIndex = (this.openIndex === i) ? null : i;
            }
        }"
        x-init="
            if (openIndex !== null) {
                const i = openIndex;
                openIndex = null;
                $nextTick(() => { openIndex = i; });
            }
        "
    >
        @foreach($items as $i => $item)
            <div
                role="button"
                tabindex="0"
                aria-controls="faq-body-{{ $i }}"
                :aria-expanded="openIndex === {{ $i }} ? 'true' : 'false'"
                @click="toggle({{ $i }})"
                @keydown.enter.prevent="toggle({{ $i }})"
                @keydown.space.prevent="toggle({{ $i }})"
                class="group cursor-pointer select-none rounded-3xl border p-5 sm:p-6 lg:p-6.5 bg-white
                       transition-colors duration-100"
                x-bind:class="openIndex === {{ $i }}
                    ? 'border-brand-300'
                    : 'border-main-200'"
            >
                <div class="w-full flex items-start sm:items-center justify-between gap-4 text-left">
                    <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                        <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 border border-brand-200/60">
                            <i class="fa-solid {{ $item['icon'] }} text-brand-600"></i>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-[15px] mb-2 sm:text-[16px] font-normal text-main-900 leading-snug">
                                {{ $item['title'] }}
                            </h3>
                            <p class="mt-1 text-[13px] font-light text-main-600 leading-snug line-clamp-2 sm:line-clamp-none">
                                {{ $item['subtitle'] }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="shrink-0 inline-flex h-10 w-10 items-center justify-center rounded-full border border-main-200 bg-white text-main-800"
                        @click.stop="toggle({{ $i }})"
                    >
                        <i
                            class="fa-solid fa-chevron-down text-[12px] transition-transform duration-150 ease-out"
                            :class="openIndex === {{ $i }} ? 'rotate-180' : 'rotate-0'"
                        ></i>
                    </span>
                </div>

                <div
                    id="faq-body-{{ $i }}"
                    x-cloak
                    x-ref="panel{{ $i }}"
                    class="overflow-hidden transition-[max-height,opacity] duration-200 ease-out"
                    :style="
                        openIndex === {{ $i }}
                            ? `max-height:${$refs['panel{{ $i }}'].scrollHeight}px; opacity:1`
                            : 'max-height:0px; opacity:0'
                    "
                >
                    <div class="mt-4 pl-12 sm:pl-13 text-sm font-light leading-relaxed text-main-600">
                        {!! nl2br(e($item['body'])) !!}
                    </div>
                </div>
            </div>
        @endforeach

        <p class="p-2 sm:p-0 mt-6 text-[13px] font-light text-main-500">
            {{ __('front.faqs.info') }}
        </p>
    </div>
</div>
