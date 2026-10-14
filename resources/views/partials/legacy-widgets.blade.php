{{-- ATOM şablonundan gelen eski widget'lar: şans çarkı, kuponlu WA popup, sağ FAB'lar.
     config('brand.features.legacy_widgets') ile açılır. --}}
    <style>
        @keyframes fadeSlide {
            0%   { opacity: 0; transform: translateY(-4px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* ===== Premium mobile FABs ===== */
        .fab-luxe{
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 9999px;
            border: 1px solid rgba(255,255,255,0.28);
            outline: none;
            cursor: pointer;
            backdrop-filter: blur(10px) saturate(140%);
            -webkit-backdrop-filter: blur(10px) saturate(140%);
            transition: transform .18s ease, box-shadow .25s ease;
            box-shadow:
                0 8px 20px -8px rgba(27, 63, 58, 0.35),
                0 2px 5px rgba(0,0,0,0.10),
                inset 0 1px 0 rgba(255,255,255,0.28);
        }
        .fab-luxe:hover{
            transform: translateY(-1px);
            box-shadow:
                0 12px 24px -8px rgba(27, 63, 58, 0.42),
                0 3px 6px rgba(0,0,0,0.12),
                inset 0 1px 0 rgba(255,255,255,0.35);
        }
        .fab-luxe:active{ transform: translateY(0) scale(0.96); }

        /* Beyaz cam zemin — açık zeminlerde */
        .fab-wa,
        .fab-brand,
        .fab-form{
            background: linear-gradient(160deg,
                rgba(255,255,255,0.32) 0%,
                rgba(255,255,255,0.22) 100%);
            transition: background .35s ease, border-color .35s ease, box-shadow .35s ease;
        }
        .fab-luxe{
            border-color: rgba(217, 124, 33, 0.28);
            box-shadow:
                0 8px 20px -8px rgba(27, 63, 58, 0.28),
                0 2px 5px rgba(0,0,0,0.06),
                inset 0 1px 0 rgba(255,255,255,0.4);
        }
        .fab-luxe .fab-icon{
            transition: color .35s ease;
        }
        /* Koyu section üstündeyken beyaz varyant */
        .fab-nav.fab-on-dark .fab-wa,
        .fab-nav.fab-on-dark .fab-brand,
        .fab-nav.fab-on-dark .fab-form{
            background: linear-gradient(160deg,
                rgba(255,255,255,0.18) 0%,
                rgba(255,255,255,0.10) 100%);
        }
        .fab-nav.fab-on-dark .fab-luxe{
            border-color: rgba(255,255,255,0.35);
            box-shadow:
                0 8px 20px -8px rgba(0,0,0,0.55),
                0 2px 5px rgba(0,0,0,0.25),
                inset 0 1px 0 rgba(255,255,255,0.25);
        }
        .fab-nav.fab-on-dark .fab-icon{
            color: #ffffff !important;
        }
        /* Modal açıkken FAB tamamen gizlensin (form butonlarıyla çakışmasın) */
        body.has-modal .fab-nav{
            opacity: 0;
            pointer-events: none;
            transition: opacity .18s ease;
        }
        /* ===== /Premium mobile FABs ===== */

        /* ===== WA Popup (uçak bileti temalı) ===== */
        .wa-pop-card{
            background:
                radial-gradient(120% 100% at 50% 0%, rgba(37,211,102,0.16) 0%, transparent 55%),
                linear-gradient(180deg, #0f2418 0%, #0a1912 60%, #070f0a 100%);
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow:
                0 30px 90px -20px rgba(0,0,0,0.75),
                0 0 0 1px rgba(37,211,102,0.10) inset;
            animation: waPopIn .28s cubic-bezier(.22,1,.36,1);
        }
        @keyframes waPopIn{
            0% { opacity: 0; transform: translateY(10px) scale(.96); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }
        .wa-pop-hero{
            border-bottom: 1px dashed rgba(255,255,255,0.10);
        }
        .wa-pop-plane{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background:
                linear-gradient(160deg, #29d872 0%, #1eb15b 55%, #0f7a3c 100%);
            box-shadow:
                0 8px 20px -6px rgba(37,211,102,0.55),
                inset 0 1px 0 rgba(255,255,255,0.35);
            transform: rotate(-8deg);
        }
        .wa-ticket{
            position: relative;
            padding: 14px 16px;
            border-radius: 14px;
            background:
                linear-gradient(160deg, rgba(255,255,255,0.06) 0%, rgba(255,255,255,0.02) 100%);
            border: 1px solid rgba(255,255,255,0.10);
        }
        .wa-ticket-notch{
            position: absolute;
            top: 50%;
            width: 14px;
            height: 14px;
            border-radius: 9999px;
            background: #070f0a; /* card zeminine denk */
            transform: translateY(-50%);
        }
        .wa-ticket-notch-l{ left: -7px; }
        .wa-ticket-notch-r{ right: -7px; }
        .wa-pop-cta{
            background: linear-gradient(160deg, #29d872 0%, #1eb15b 55%, #0f7a3c 100%);
            box-shadow:
                0 14px 28px -10px rgba(37,211,102,0.55),
                inset 0 1px 0 rgba(255,255,255,0.30);
        }
        .wa-pop-cta:hover{
            filter: brightness(1.06);
        }
        /* ===== /WA Popup ===== */

        @keyframes waShimmer {
            0%   { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }
        .wa-shimmer-border{
            background-image: linear-gradient(
                110deg,
                color-mix(in srgb, var(--color-brand-700) 0%, transparent) 0%,
                color-mix(in srgb, var(--color-brand-500) 62%, transparent) 36%,
                color-mix(in srgb, var(--color-brand-400) 70%, transparent) 32%,
                color-mix(in srgb, var(--color-brand-300) 48%, transparent) 68%,
                color-mix(in srgb, var(--color-brand-600) 18%, transparent) 62%,
                color-mix(in srgb, var(--color-brand-500) 0%, transparent) 78%
            );

            background-size: 220% 220%;
            animation: waShimmer 1.6s linear infinite alternate;
        }

        @keyframes spinSlideIn {
            0%   { transform: translateX(5rem) rotate(0deg) scale(.92); opacity: 0; }
            100% { transform: translateX(0)    rotate(360deg) scale(1);  opacity: 1; }
        }

        @keyframes spinIdle {
            0%   { transform: rotate(0deg)   scale(1);    filter: brightness(1); }
            25%  { transform: rotate(-90deg)  scale(1.05); filter: brightness(1.62); }
            50%  { transform: rotate(-180deg) scale(1);    filter: brightness(1.21); }
            75%  { transform: rotate(-270deg) scale(1.08); filter: brightness(0.92); }
            100% { transform: rotate(-360deg) scale(1);    filter: brightness(1); }
        }

        /* Başlangıç: görünmesin */
        .spin-enter{
            box-shadow: 0px 0px 8px #00000059;
            border-radius: 90px;
            opacity: 0;
            transform: translateX(5rem);
            will-change: transform, opacity, filter;
        }

        /* 1 sn sonra giriş */
        .spin-enter.is-in{
            animation: spinSlideIn .8s cubic-bezier(.22,1,.36,1) forwards;
        }

        /* Giriş bitince sürekli animasyon */
        .spin-enter.is-idle{
            opacity: 1;
            transform: translateX(0);
            animation: spinIdle 4s linear infinite;
        }

        .cta-after-spin{
            opacity: 0;
            animation: ctaFadeIn .45s ease forwards;
            animation-delay: 1200ms; /* spin enter süresi */
        }

        @keyframes ctaFadeIn{
            to { opacity: 1; }
        }


    </style>
<script>
    function bootSpinEnter() {
        const el = document.querySelector('.spin-enter');
        if (!el) return;

        // ✅ tekrar tekrar çalışmasın
        if (el.dataset.spinBooted === '1') return;
        el.dataset.spinBooted = '1';

        // reset (navigate ile geri gelince class kalmış olabilir)
        el.classList.remove('is-in', 'is-idle');

        setTimeout(() => {
            el.classList.add('is-in');

            const onEnd = (e) => {
                if (e.animationName === 'spinSlideIn') {
                    el.classList.remove('is-in');
                    el.classList.add('is-idle');
                }
            };

            // ✅ aynı elemente 50 kere listener ekleme
            el.addEventListener('animationend', onEnd);
        }, 1000);
    }

    // İlk yükleme
    document.addEventListener('DOMContentLoaded', bootSpinEnter);

    // ✅ Livewire navigate sonrası (asıl mesele)
    document.addEventListener('livewire:navigated', () => {
        // yeni DOM geldi, tekrar çalıştır
        // dataset kilidi eski elementte kaldıysa sorun yok çünkü yeni element gelir
        bootSpinEnter();
    });

    // ✅ bfcache (Safari/geri tuşu) için
    window.addEventListener('pageshow', () => bootSpinEnter());

    /* ===== FAB adaptif tema (elementFromPoint) + modal-aware gizleme ===== */
    (() => {
        const DARK_SELECTOR = [
            '[class*="bg-main-7"]','[class*="bg-main-8"]','[class*="bg-main-9"]','[class*="bg-main-950"]',
            '[class*="bg-brand-8"]','[class*="bg-brand-9"]',
            '[class*="bg-black"]','[class*="bg-neutral-9"]','[class*="bg-slate-9"]','[class*="bg-zinc-9"]','[class*="bg-stone-9"]',
            '[class*="from-main-7"]','[class*="from-main-8"]','[class*="from-main-9"]',
            '[class*="via-main-7"]','[class*="via-main-8"]','[class*="via-main-9"]',
            '[class*="to-main-7"]','[class*="to-main-8"]','[class*="to-main-9"]',
            '[class*="from-brand-8"]','[class*="from-brand-9"]',
            '[class*="via-brand-8"]','[class*="via-brand-9"]',
            '[class*="to-brand-8"]','[class*="to-brand-9"]',
            '[class*="from-black"]','[class*="via-black"]','[class*="to-black"]',
            '[class*="from-neutral-9"]','[class*="from-slate-9"]','[class*="from-zinc-9"]','[class*="from-stone-9"]',
        ].join(',');

        function isLargeEnough(el) {
            const r = el.getBoundingClientRect();
            return r.height >= 200 && r.width >= window.innerWidth * 0.5;
        }

        function isDarkAtFab() {
            const nav = document.querySelector('.fab-nav');
            if (!nav) return false;
            const prev = nav.style.pointerEvents;
            nav.style.pointerEvents = 'none';
            const r = nav.getBoundingClientRect();
            const x = Math.min(window.innerWidth - 2, Math.max(0, r.left + r.width / 2));
            const y = Math.min(window.innerHeight - 2, Math.max(0, r.top + r.height / 2));
            // Tüm stack'i al — dark overlay content'in kardeşiyse .closest kaçırır
            const stack = document.elementsFromPoint(x, y) || [];
            nav.style.pointerEvents = prev;

            for (const el of stack) {
                if (el.closest?.('.fab-nav')) continue;
                // Element'in kendisi veya bir ATASI dark class taşıyor mu?
                const dark = el.closest?.(DARK_SELECTOR);
                if (dark && isLargeEnough(dark)) return true;
                // Element'in kendisi veya bir ATASI, dark kaplayan bir child (overlay) barındırıyor mu?
                if (el.matches?.(DARK_SELECTOR) && isLargeEnough(el)) return true;
            }
            return false;
        }

        let rafId = 0;
        function apply() {
            const nav = document.querySelector('.fab-nav');
            if (!nav) return;
            nav.classList.toggle('fab-on-dark', isDarkAtFab());
        }
        function scheduleApply() {
            if (rafId) return;
            rafId = requestAnimationFrame(() => { rafId = 0; apply(); });
        }

        function refreshModalState() {
            const overlays = document.querySelectorAll('.fixed.inset-0');
            let visible = false;
            for (const el of overlays) {
                if (getComputedStyle(el).display === 'none') continue;
                if (getComputedStyle(el).visibility === 'hidden') continue;
                if (el.getBoundingClientRect().width === 0) continue;
                visible = true;
                break;
            }
            document.body.classList.toggle('has-modal', visible);
        }

        function boot() {
            scheduleApply();
            refreshModalState();
        }

        // Scroll / resize / DOM değişikliği → yeniden değerlendir
        window.addEventListener('scroll', scheduleApply, { passive: true });
        window.addEventListener('resize', scheduleApply);

        const mo = new MutationObserver(() => { scheduleApply(); refreshModalState(); });
        mo.observe(document.documentElement, { childList: true, subtree: true, attributes: true, attributeFilter: ['class', 'style'] });

        document.addEventListener('DOMContentLoaded', boot);
        document.addEventListener('livewire:navigated', boot);
        window.addEventListener('pageshow', boot);
    })();
</script>
<livewire:ui.modals.lucky-spin-modal />
{{-- WhatsApp intent popup (kupon kodlu, wa-direct sadece iç CTA'da) --}}
<div id="wa-popup" class="fixed inset-0 z-[200000] hidden items-center justify-center p-4"
     style="background: rgba(6,14,10,0.72); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);"
     data-wa-phone="{{ $whatsappLink }}"
     data-wa-message="{{ __('front.global.wa-popup.message') }}"
     onclick="if(event.target===this) window.__waPopup.close()">

    <div class="wa-pop-card relative w-full max-w-[380px] rounded-[22px] overflow-hidden">

        {{-- kapat --}}
        <button type="button" onclick="window.__waPopup.close()"
                aria-label="Kapat"
                class="absolute right-3.5 top-3.5 z-20 flex h-8 w-8 items-center justify-center rounded-full text-white/60 hover:text-white hover:bg-white/10 transition cursor-pointer">
            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
        </button>

        {{-- ÜST BÖLÜM: uçak bileti hero'su --}}
        <div class="wa-pop-hero relative px-6 pt-6 pb-5 text-center">
            <div class="flex justify-center">
                <div class="wa-pop-plane">
                    <i class="fa-solid fa-plane-departure text-white text-[16px]"></i>
                </div>
            </div>

            <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/8 border border-white/15 px-3 py-1 text-[10px] font-semibold tracking-[0.24em] uppercase text-emerald-200">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400" style="box-shadow: 0 0 0 3px rgba(52,211,153,0.25)"></span>
                {{ __('front.global.wa-popup.badge') }}
            </div>

            <h3 class="mt-3 text-[19px] sm:text-[21px] font-semibold leading-snug text-white tracking-tight">
                {{ __('front.global.wa-popup.title') }}
            </h3>
        </div>

        {{-- KUPON TICKET --}}
        <div class="relative px-5">
            <div class="wa-ticket text-center">
                <span class="wa-ticket-notch wa-ticket-notch-l"></span>
                <span class="wa-ticket-notch wa-ticket-notch-r"></span>

                <p class="text-[10px] font-medium tracking-[0.28em] uppercase text-white/50">
                    {{ __('front.global.wa-popup.coupon-label') }}
                </p>
                <p data-wa-coupon class="mt-1 font-mono text-[22px] font-bold tracking-widest text-emerald-300">{{ config('brand.coupon_code') }}</p>

                <div class="mt-3 border-t border-dashed border-white/12 pt-3 text-[12.5px] leading-relaxed text-white/75">
                    {{ __('front.global.wa-popup.card-desc') }}
                </div>
            </div>
        </div>

        {{-- CTA --}}
        <div class="px-5 pt-4 pb-5">
            <a href="#"
               target="_blank"
               rel="noopener"
               data-wa-cta
               onclick="window.__waPopup.close()"
               class="wa-direct wa-pop-cta group inline-flex w-full items-center justify-center gap-2.5 rounded-xl px-5 py-3.5 text-[14px] font-semibold text-white transition cursor-pointer">
                <i class="fa-brands fa-whatsapp text-[18px]"></i>
                <span>{{ __('front.global.wa-popup.cta') }}</span>
                <svg class="ml-0.5 transition group-hover:translate-x-0.5" viewBox="0 0 20 20" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 10h12M12 5l5 5-5 5"/></svg>
            </a>

            <button type="button" onclick="window.__waPopup.close()"
                    class="mt-2.5 block w-full text-center text-[12px] text-white/50 hover:text-white/80 transition cursor-pointer">
                {{ __('front.global.wa-popup.later') }}
            </button>
        </div>
    </div>
</div>
<script>
    (() => {
        const popup = document.getElementById('wa-popup');
        const phone = popup.dataset.waPhone;
        const msgTemplate = popup.dataset.waMessage;

        // Sabit kampanya kodu — WhatsApp konuşmalarında bu kodu arayarak dönüşüm ölçülür
        const COUPON_CODE = @js(config('brand.coupon_code'));

        function applyCoupon(code) {
            popup.querySelectorAll('[data-wa-coupon]').forEach(el => el.textContent = code);
            const cta = popup.querySelector('[data-wa-cta]');
            if (cta && phone && msgTemplate) {
                const msg = msgTemplate.split(':coupon').join(code);
                cta.setAttribute('href', 'https://wa.me/' + phone + '?text=' + encodeURIComponent(msg));
            }
        }

        // Bir kez uygula (sabit kod, tekrar üretmeye gerek yok)
        applyCoupon(COUPON_CODE);

        const open = () => {
            popup.classList.remove('hidden');
            popup.classList.add('flex');
            document.body.classList.add('overflow-hidden');
        };
        const close = () => {
            popup.classList.add('hidden');
            popup.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        };
        window.__waPopup = { open, close };

        // wa-popup-trigger sınıflı tüm butonlar popup'ı açsın (direct WA linkine gitmesin)
        document.addEventListener('click', (e) => {
            const t = e.target.closest('.wa-popup-trigger');
            if (!t) return;
            e.preventDefault();
            e.stopPropagation();
            open();
        }, true);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !popup.classList.contains('hidden')) close();
        });
    })();
</script>

{{-- MOBİL SAĞDA DİKEY İLETİŞİM FAB'LARI (sağ elle baş parmakla erişilebilir) --}}
<nav aria-label="Hızlı iletişim"
     class="fab-nav lg:hidden fixed right-3 top-1/2 -translate-y-1/2 z-[90] flex flex-col gap-2.5">

    {{-- WhatsApp --}}
    <a href="https://wa.me/{{ $whatsappLink }}"
       aria-label="WhatsApp"
       class="wa-popup-trigger fab-luxe fab-wa">
        <i class="fa-brands fa-whatsapp text-[22px] text-brand-400 fab-icon"></i>
    </a>

    {{-- Telefon Ara --}}
    <a href="tel:{{ $phoneLink }}"
       aria-label="Telefonla ara"
       class="fab-luxe fab-brand">
        <i class="fa-solid fa-phone text-[16px] text-brand-400 fab-icon"></i>
    </a>

    {{-- Form (Book Consultation) --}}
    <button type="button"
            aria-label="{{ __('front.global.consultation') }}"
            onclick="Livewire.dispatch('open-book-consultation')"
            class="fab-luxe fab-form">
        <i class="fa-regular fa-pen-to-square text-[16px] text-brand-400 fab-icon"></i>
    </button>
</nav>

<a href="https://wa.me/{{ $whatsappLink }}"
   aria-label="WhatsApp Consultation"
   class="wa-popup-trigger fixed bottom-6 lg:hover:-translate-y-0.5  transition left-4 lg:bottom-7 sm:left-7 z-[9999]">

    <!-- shimmer border (NO SHADOW) -->
    <div class="relative rounded-xl p-[1.2px] wa-shimmer-border">

        <!-- inner button -->
        <div class="flex items-center gap-3 rounded-xl
                  bg-white
                  px-3.5 py-2.5
                  border border-main-200/60
                  ">

          <span class="flex h-9 w-9 items-center justify-center rounded-xl
                       bg-gradient-to-r from-brand-400 via-brand-500 to-brand-600
                       text-white">
              <i class="fa-brands fa-whatsapp text-[15px] opacity-90"></i>
          </span>

            <span class="h-6 w-px bg-main-400/40"></span>

            <span class="flex flex-col leading-tight">
              <span class="text-[11px] font-medium uppercase tracking-[0.24em] text-main-900">
                  WhatsApp
              </span>
              <span class="text-[9.5px] mt-0.5 uppercase tracking-[0.32em] text-brand-700">
                  {{ __('front.global.consultation') }}
              </span>
          </span>

            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-green-500/80"></span>
        </div>
    </div>
</a>



@php
    $isThankYou = str_contains(request()->path(), 'thank-you');
@endphp

@if(!$isThankYou)
    <div class="hidden md:block wheel-toggle fixed small-spin z-[999] spin-enter bottom-8 right-9 cursor-pointer"
         wire:ignore
         onclick="window.dispatchEvent(new CustomEvent('open-luckyspin'))">
        <img src="{{ asset('img/lucky-spin-small.png') }}"
             width="50px"
             alt="{{ __('partials.spin-show-hide') }}">
    </div>

    <div class="hidden md:block md:fixed bottom-8 md:right-16 z-[99] cursor-pointer select-none cta-after-spin"
         wire:ignore
         onclick="window.dispatchEvent(new CustomEvent('open-luckyspin'))">
        {{-- OUTER: copper gradient border (left strong) --}}
        <div
            class="relative inline-block p-[1.5px]"
            style="
                border-radius:7px;
                background: linear-gradient(
                    90deg,
                    color-mix(in srgb, var(--color-brand-600) 45%, transparent),
                    color-mix(in srgb, var(--color-brand-400) 20%, transparent),
                    transparent
                );
            "
        >
            {{-- INNER: white card fading to the right --}}
            <div
                class="relative overflow-hidden
                       pl-5 pr-7.5 py-1.5
                       text-[13px] italic font-normal tracking-tight
                       bg-white/95 backdrop-blur text-brand-800"
                style="border-radius:6px;"
            >
                {{ __('front.global.try-your-chance') }}

                {{-- minimal direction hint --}}
                <span class="relative ml-1 not-italic text-[15px] text-brand-700/60">&rsaquo;</span>
            </div>
        </div>
    </div>
@endif
