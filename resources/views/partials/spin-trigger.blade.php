{{-- Sağ alt: Tanışma kampanyası butonu (masaüstü) — çark modalını açar.
     Altın hediye rozeti kayarak girer, ara ara sallanır; çevresinde küçük yıldızlar parlar. --}}
@unless(str_contains(request()->path(), 'thank-you'))
    <div class="float-fab fixed right-6 bottom-6 z-40 hidden lg:block" wire:ignore>
        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-luckyspin'))"
                aria-label="Tanışma kampanyası çarkını aç"
                class="group flex cursor-pointer items-center select-none">

            {{-- Yazı kartı: beyaz, ince açık mavi kenar; tek altın vurgu HEDİYE etiketi --}}
            <span class="spin-fab-cta relative -mr-6 rounded-full p-px"
                  style="background: linear-gradient(100deg, rgba(148,176,226,.7), rgba(68,105,179,.45) 50%, rgba(185,205,240,.3));">
                <span class="relative flex items-center gap-2 overflow-hidden rounded-full bg-white py-1.5 pr-9 pl-2 shadow-[0_12px_28px_-16px_rgba(22,43,87,.55)]">
                    <span class="rounded-full bg-[#c9973f]/10 px-2 py-0.5 text-[8.5px] font-semibold uppercase tracking-[0.18em] text-[#b07d34] ring-1 ring-[#c9973f]/35">Hediye</span>
                    <span class="text-[13px] whitespace-nowrap text-brand-900"><span class="font-light">Tanışma</span> <span class="font-semibold">Kampanyası</span></span>
                    <span aria-hidden="true" class="spin-fab-shine pointer-events-none absolute inset-y-0 -left-1/2 w-1/3 -skew-x-12 bg-gradient-to-r from-transparent via-brand-100/70 to-transparent"></span>
                </span>
            </span>

            {{-- Lacivert hediye rozeti + büyüyüp küçülen, renk değiştiren yıldızlar --}}
            <span class="spin-fab-gift relative z-10 block h-12 w-12">
                <span class="flex h-full w-full items-center justify-center rounded-full ring-2 ring-white shadow-[0_10px_24px_-10px_rgba(22,43,87,.75)]"
                      style="background: radial-gradient(120% 120% at 30% 20%, var(--color-brand-500) 0%, var(--color-brand-800) 55%, var(--color-brand-900) 100%);">
                    <i class="spin-fab-gift-icon fa-solid fa-gift text-[17px] text-white drop-shadow-[0_2px_4px_rgba(0,0,0,.3)]"></i>
                </span>
                <i aria-hidden="true" class="spin-fab-star fa-solid fa-star absolute -top-1 -left-1 text-[7.5px]"></i>
                <i aria-hidden="true" class="spin-fab-star fa-solid fa-star absolute -right-1 top-1.5 text-[6px] [animation-delay:-.8s]"></i>
                <i aria-hidden="true" class="spin-fab-star fa-solid fa-star absolute right-0 -bottom-1 text-[7px] [animation-delay:-1.6s]"></i>
            </span>
        </button>
    </div>
@endunless
