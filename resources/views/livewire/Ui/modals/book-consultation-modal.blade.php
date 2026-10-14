{{-- Randevu penceresi — çıkış penceresiyle aynı tasarım: hekim fotoğraflı lacivert başlık + form + hızlı kanallar --}}
<div wire:keydown.escape.window="closeModal">
    @if($open)
        <div class="exit-overlay fixed inset-0 z-[100000] flex items-center justify-center bg-brand-900/55 p-3 backdrop-blur-sm sm:p-6"
             wire:click="closeModal">

            <div class="exit-panel relative max-h-[calc(100dvh-1.5rem)] w-full max-w-[540px] overflow-y-auto overscroll-contain rounded-[24px] bg-white shadow-[0_40px_100px_-30px_rgba(22,43,87,.65)] sm:max-h-[calc(100dvh-3rem)] sm:rounded-[28px]"
                 role="dialog" aria-modal="true" aria-labelledby="book-title" wire:click.stop>

                {{-- Lacivert başlık --}}
                <div class="relative isolate overflow-hidden bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 px-5 pt-5 pb-6 text-white sm:px-8 sm:pt-6 sm:pb-7">
                    <div aria-hidden="true" class="absolute inset-0 -z-10 bg-[radial-gradient(60%_90%_at_100%_0%,rgba(148,176,226,.3),transparent_65%)]"></div>
                    <x-logo-mark class="pointer-events-none absolute -right-10 -bottom-12 -z-10 h-[200px] w-auto opacity-[.07]" style="--logo-ink:#fff; --logo-accent:#fff;" />

                    <div class="flex items-center justify-between">
                        <x-logo tone="light" class="text-[14px]" />
                        <button type="button" wire:click="closeModal" aria-label="Kapat"
                                class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full bg-white/10 text-white/80 ring-1 ring-white/15 transition hover:bg-white/20 hover:text-white">
                            <i class="fa-solid fa-xmark text-[14px]"></i>
                        </button>
                    </div>

                    <div class="mt-6 flex items-center gap-4">
                        <img src="{{ asset('img/lp/invisalign/dr-fatih-kahraman.webp') }}" alt="{{ config('brand.doctor.name') }}" loading="lazy"
                             class="h-16 w-16 shrink-0 rounded-2xl bg-white object-cover object-top ring-2 ring-white/30 sm:h-[72px] sm:w-[72px]">
                        <div>
                            <p class="flex items-center gap-2 text-[10.5px] font-semibold uppercase tracking-[0.22em] text-[#e2b979]">
                                <span class="h-px w-5 bg-[#e2b979]"></span> Ücretsiz Muayene
                            </p>
                            <h3 id="book-title" class="mt-1.5 text-[22px] leading-tight tracking-[-0.01em] sm:text-[26px]">
                                <span class="font-light">Randevunuzu</span> <span class="font-semibold">Planlayalım</span>
                            </h3>
                            <p class="mt-1 text-[13px] text-white/65">{{ config('brand.doctor.name') }} · Ortodonti Uzmanı</p>
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-1.5">
                        @foreach(['Kişiye Özel Plan', 'Şeffaf Planlama', 'Detaylı Teşhis'] as $perk)
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-2.5 py-1 text-[11px] font-medium text-white/85 ring-1 ring-white/15">
                                <i class="fa-solid fa-check text-[9px] text-[#e2b979]"></i> {{ $perk }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Form --}}
                <div class="px-5 pt-5 pb-5 sm:px-8 sm:pt-6 sm:pb-6">
                    <p class="mb-4 text-[13.5px] leading-relaxed text-main-500">Bilgilerinizi bırakın, en kısa sürede sizinle iletişime geçelim.</p>
                    <livewire:ui.forms.simple-form :key="'simple-form-modal-' . md5($topic)" layout="lead-compact" variant="light"
                        :email-required="true" :require-consent="true" :with-topic="false" :topic="$topic" form-key="modal" />
                </div>

                {{-- Hızlı kanallar --}}
                <div class="flex items-center justify-between gap-3 border-t border-main-100 bg-main-50/70 px-5 py-3.5 sm:px-8">
                    <p class="text-[11.5px] font-semibold uppercase tracking-[0.16em] text-main-400">veya hemen ulaşın</p>
                    <div class="flex gap-2">
                        <a href="tel:+{{ preg_replace('/\D+/', '', config('brand.contact.phone_link')) }}" aria-label="Ara"
                           class="flex h-10 w-10 items-center justify-center rounded-full border border-main-200 bg-white text-brand-700 transition hover:border-brand-300">
                            <i class="fa-solid fa-phone text-[13px]"></i>
                        </a>
                        <a href="{{ \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener" aria-label="WhatsApp"
                           class="flex h-10 items-center gap-2 rounded-full bg-[#25D366] px-4 text-[13px] font-semibold text-white transition hover:brightness-105">
                            <i class="fa-brands fa-whatsapp text-[16px]"></i> WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
