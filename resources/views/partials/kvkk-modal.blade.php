{{-- KVKK Aydınlatma Metni — site içi açılır pencere.
     Açmak için: href="#kvkk" olan herhangi bir link (app.js dinler) veya window 'open-kvkk' event'i.
     TODO: Metin hukuk danışmanı tarafından teyit edilmeli. --}}
@php
    $email = config('brand.contact.email');
    $h = 'mt-7 text-[13px] font-semibold uppercase tracking-[0.14em] text-brand-800';
    $p = 'mt-2.5 text-[14.5px] leading-relaxed text-main-600';
@endphp

<div x-data="{ open: false }"
     x-on:open-kvkk.window="open = true; document.documentElement.style.overflow = 'hidden'"
     x-on:keydown.escape.window="if (open) { open = false; document.documentElement.style.overflow = '' }"
     x-effect="if (!open) document.documentElement.style.overflow = ''"
     x-show="open" x-cloak
     class="fixed inset-0 z-[100020] flex items-end justify-center p-0 sm:items-center sm:p-6"
     role="dialog" aria-modal="true" aria-labelledby="kvkk-title">

    {{-- Arka plan --}}
    <div x-show="open" x-transition.opacity.duration.300ms @click="open = false"
         class="absolute inset-0 bg-brand-900/60 backdrop-blur-sm"></div>

    {{-- Pencere --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-6 sm:scale-[.98]" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-4"
         class="relative flex max-h-[88vh] w-full max-w-2xl flex-col overflow-hidden rounded-t-[26px] bg-white shadow-[0_40px_90px_-30px_rgba(22,43,87,.6)] sm:rounded-[26px]">

        {{-- Başlık --}}
        <div class="flex items-start justify-between gap-4 border-b border-main-100 px-6 pt-6 pb-5 sm:px-8">
            <div>
                <p class="flex items-center gap-3 text-[11px] font-medium uppercase tracking-[0.28em] text-brand-600">
                    <span class="h-px w-8 bg-[#c9973f]"></span> Kişisel verilerin korunması
                </p>
                <h2 id="kvkk-title" class="mt-3 text-[24px] leading-tight font-light text-brand-900 sm:text-[28px]">KVKK <span class="font-semibold">Aydınlatma Metni</span></h2>
            </div>
            <button type="button" @click="open = false" aria-label="Kapat"
                    class="inline-flex h-10 w-10 shrink-0 cursor-pointer items-center justify-center rounded-full border border-main-200 text-main-500 transition hover:border-main-300 hover:text-main-900">
                <i class="fa-solid fa-xmark text-[14px]"></i>
            </button>
        </div>

        {{-- İçerik --}}
        <div class="overflow-y-auto overscroll-contain px-6 pb-8 sm:px-8">
            <p class="{{ $p }} mt-6">
                6698 sayılı Kişisel Verilerin Korunması Kanunu (“KVKK”) uyarınca, {{ config('brand.name') }} – {{ config('brand.doctor.name') }} (“Veri Sorumlusu”) olarak, bu internet sitesi üzerinden paylaştığınız kişisel verilerinizi aşağıda açıklanan kapsamda işlemekteyiz.
            </p>

            <h3 class="{{ $h }}">1. İşlenen kişisel veriler</h3>
            <ul class="mt-2.5 list-disc space-y-1.5 pl-5 text-[14.5px] leading-relaxed text-main-600 marker:text-[#c9973f]">
                <li><strong class="font-medium text-main-800">Kimlik ve iletişim:</strong> ad soyad, telefon numarası, e-posta adresi.</li>
                <li><strong class="font-medium text-main-800">Talep bilgileri:</strong> formda seçtiğiniz tedavi tercihi ve diş durumu, kimin için başvurduğunuz, kampanya kapsamında kazandığınız hediye.</li>
                <li><strong class="font-medium text-main-800">İşlem güvenliği:</strong> IP adresi, tarayıcı bilgisi, yaklaşık konum ve başvuru zamanı.</li>
            </ul>

            <h3 class="{{ $h }}">2. İşleme amaçları</h3>
            <p class="{{ $p }}">
                Muayene ve ön değerlendirme talebinizin alınması, sizinle telefon, e-posta veya WhatsApp üzerinden iletişime geçilmesi, randevunuzun planlanması, kampanya hediyesinin tanımlanması, başvuruların güvenliğinin sağlanması ve kötüye kullanımın önlenmesi ile yasal yükümlülüklerin yerine getirilmesi.
            </p>

            <h3 class="{{ $h }}">3. Hukuki sebepler</h3>
            <p class="{{ $p }}">
                Kişisel verileriniz; KVKK’nın 5. maddesinde yer alan bir sözleşmenin kurulması veya ifasıyla doğrudan ilgili olması, veri sorumlusunun hukuki yükümlülüğünü yerine getirmesi ve meşru menfaati hukuki sebeplerine dayanılarak işlenir. Formda paylaştığınız diş durumu gibi sağlık verisi niteliği taşıyabilecek bilgiler, KVKK’nın 6. maddesi uyarınca açık rızanıza dayanılarak işlenir.
            </p>

            <h3 class="{{ $h }}">4. Aktarım</h3>
            <p class="{{ $p }}">
                Kişisel verileriniz, yukarıdaki amaçlarla sınırlı olarak; muayenenin gerçekleştirildiği polikliniklerle, barındırma ve e-posta gibi bilişim altyapısı hizmeti aldığımız tedarikçilerle (yurt dışında bulunanlar dahil) ve talep halinde yetkili kamu kurum ve kuruluşlarıyla paylaşılabilir.
            </p>

            <h3 class="{{ $h }}">5. Toplama yöntemi</h3>
            <p class="{{ $p }}">
                Verileriniz bu internet sitesindeki formlar, WhatsApp ve telefon aracılığıyla, kısmen otomatik yollarla elektronik ortamda toplanır.
            </p>

            <h3 class="{{ $h }}">6. Haklarınız</h3>
            <p class="{{ $p }}">KVKK’nın 11. maddesi uyarınca; kişisel verilerinizin işlenip işlenmediğini öğrenme, işlenmişse bilgi talep etme, işlenme amacını ve amaca uygun kullanılıp kullanılmadığını öğrenme, aktarıldığı üçüncü kişileri bilme, eksik veya yanlış işlenmişse düzeltilmesini, şartları oluştuğunda silinmesini veya yok edilmesini isteme, bu işlemlerin aktarılan üçüncü kişilere bildirilmesini isteme, münhasıran otomatik sistemlerle analiz edilmesi sonucu aleyhinize bir sonuç çıkmasına itiraz etme ve kanuna aykırı işleme nedeniyle zarara uğramanız hâlinde zararın giderilmesini talep etme haklarına sahipsiniz.</p>

            <h3 class="{{ $h }}">7. Başvuru</h3>
            <p class="{{ $p }}">
                Haklarınıza ilişkin taleplerinizi <a href="mailto:{{ $email }}" class="font-medium text-brand-700 underline underline-offset-2">{{ $email }}</a> adresine iletebilirsiniz. Başvurunuz en geç 30 gün içinde ücretsiz olarak sonuçlandırılır.
            </p>
        </div>

        {{-- Alt --}}
        <div class="flex items-center justify-end border-t border-main-100 bg-main-50/60 px-6 py-4 sm:px-8">
            <button type="button" @click="open = false"
                    class="btn-accent inline-flex cursor-pointer items-center gap-2 rounded-xl px-5 py-2.5 text-[12px] font-semibold uppercase tracking-[0.14em]">
                Okudum, anladım
            </button>
        </div>
    </div>
</div>
