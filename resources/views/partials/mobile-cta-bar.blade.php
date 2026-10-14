{{-- Mobilde ekranın altında sabit iletişim barı --}}
<div class="fixed inset-x-0 bottom-0 z-40 border-t border-main-100 bg-white/95 px-3 pt-2.5 pb-[calc(.625rem+env(safe-area-inset-bottom))] backdrop-blur-md lg:hidden">
    <div class="grid grid-cols-[auto_auto_1fr] gap-2">
        <a href="tel:{{ $phoneLink }}" aria-label="Ara"
           class="inline-flex h-12 w-12 items-center justify-center rounded-xl border border-main-200 text-main-900">
            <i class="fa-solid fa-phone text-[15px]"></i>
        </a>
        <a href="{{ $whatsappUrl ?? \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener" aria-label="WhatsApp"
           class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-[#25D366] text-white">
            <i class="fa-brands fa-whatsapp text-[20px]"></i>
        </a>
        <button type="button" onclick="Livewire.dispatch('open-book-consultation')"
                class="btn-accent inline-flex h-12 cursor-pointer items-center justify-center gap-2 rounded-xl text-[14.5px] font-semibold">
            Ücretsiz muayene <i class="fa-solid fa-arrow-right text-[12px]"></i>
        </button>
    </div>
</div>

{{-- Masaüstü: sol altta WhatsApp — yeşil mühür rozet: içte dönen beyaz yazı, ortada beyaz disk --}}
<a href="{{ $whatsappUrl ?? \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener" aria-label="WhatsApp ile yazın" title="WhatsApp ile yazın"
   class="float-fab group fixed bottom-6 left-6 z-40 hidden lg:block">
    <span class="relative flex h-[66px] w-[66px] items-center justify-center rounded-full ring-[3px] ring-white shadow-[0_14px_32px_-14px_rgba(18,140,74,.85)] transition duration-300 group-hover:scale-[1.04]"
          style="background: radial-gradient(120% 120% at 30% 20%, #3ee07f 0%, #22c35e 50%, #12a150 100%);">
        <svg viewBox="0 0 100 100" class="wa-orbit absolute inset-0 h-full w-full" aria-hidden="true">
            <defs><path id="wa-orbit-path" d="M50,50 m-35,0 a35,35 0 1,1 70,0 a35,35 0 1,1 -70,0"/></defs>
            <text font-size="9" font-weight="700" letter-spacing="1.6" fill="rgba(255,255,255,.92)">
                <textPath href="#wa-orbit-path" textLength="216" lengthAdjust="spacing">WHATSAPP • BİLGİ AL • </textPath>
            </text>
        </svg>
        <span class="relative flex h-[30px] w-[30px] items-center justify-center rounded-full bg-white text-[#14a24f] shadow-[0_4px_10px_-4px_rgba(0,0,0,.35)]">
            <i class="fa-brands fa-whatsapp text-[18px]"></i>
        </span>
    </span>
</a>
