<?php

namespace App\Livewire\Invisalign;

class Index extends Base
{
    public array $caseItems = [];
    public array $facts = [];
    public array $benefits = [];
    public array $compareRows = [];
    public array $audiences = [];
    public array $steps = [];
    public array $dayItems = [];
    public array $retention = [];
    public array $faqItems = [];
    public array $reviews = [];

    protected array $seoOverride = [];

    public function mount(): void
    {
        parent::mount();

        # İçerikler boş kalırsa Base.php deki SEO kullanılır.
        $seoByLocale = [
            'tr' => [
                # 'title' => '',
                # 'description' => '',
                # 'og_image' => asset(''),
            ],
        ];

        $loc = app()->getLocale();

        if (isset($seoByLocale[$loc])) {
            $this->seoOverride = [
                'seo' => $seoByLocale[$loc],
            ];
        }

        ## ------- TEDAVİ EDİLEN DURUMLAR (videolu sekmeler) -------- ##
        // TODO: Videolar (CDN) ve ikonlar (public/img/invisalign/bite) invisalign.com.tr'den — Align Technology'ye ait.
        // Yayına çıkmadan önce Kahraman Ortodonti'nin Align temsilcisinden alacağı resmi materyallerle
        // public/videos/invisalign/{key}.mp4 olarak değiştirilmeli.
        $cdn = 'https://videos.ctfassets.net/vh25xg5i1h5l';

        $this->caseItems = [
            [
                'key'   => 'derin',
                'title' => 'Derin kapanış',
                'lead'  => 'Ağız kapalıyken üst ön dişler alt ön dişlerin üzerine fazla miktarda biner.',
                'risks' => ['Alt dişlerde aşınmaya yol açabilir', 'Diş etlerine baskı yapabilir', 'Çene eklemi rahatsızlıklarına zemin hazırlayabilir'],
                'fix'   => 'Plaklar ön dişlerin dikey konumunu düzenleyerek kapanışı dengeler.',
                'video' => "{$cdn}/236v4drIZbigR6MvoF83FV/e5ae5694fb76028c2f2612b8f4d42715/video-resources-overbite-timelapse.mp4",
            ],
            [
                'key'   => 'ters',
                'title' => 'Ters kapanış',
                'lead'  => 'Alt ön dişler, ağız kapalıyken üst ön dişlerin önünde konumlanır.',
                'risks' => ['Çiğneme ve konuşmayı etkileyebilir', 'Dişlerde aşınmayı hızlandırabilir', 'Çene eklemine yük bindirebilir'],
                'fix'   => 'Uygun vakalarda plaklar dişleri kademeli olarak doğru konuma taşıyarak kapanışı düzeltir.',
                'video' => "{$cdn}/1Q5ZopD2NN8QejfyWG2fzi/3696b6533ab864ef046c2dfa7b303925/video-resources-underbite-timelapse.mp4",
            ],
            [
                'key'   => 'capraz',
                'title' => 'Çapraz kapanış',
                'lead'  => 'Bazı üst dişler, ağız kapalıyken alt dişlerin iç tarafında kalır.',
                'risks' => ['Dişlerde kırılma ve aşınma riski', 'Diş eti çekilmesine yol açabilir', 'Çenenin asimetrik gelişmesine neden olabilir'],
                'fix'   => 'Plaklar ilgili dişleri dışa doğru yönlendirerek alt ve üst çenenin uyumunu sağlar.',
                'video' => "{$cdn}/3Bvv4lc2toUGk7kIVCCQYh/4999902bb08d932f002ea928e48949ee/video-resources-crossbite-timelapse.mp4",
            ],
            [
                'key'   => 'bosluk',
                'title' => 'Dişler arası boşluklar',
                'lead'  => 'Dişler arasında, özellikle ön bölgede belirgin açıklıklar bulunur.',
                'risks' => ['Yiyecek sıkışmasına neden olur', 'Diş etlerini hassaslaştırabilir', 'Gülüşte estetik kaygıya yol açar'],
                'fix'   => 'Plaklar dişleri kontrollü biçimde birbirine yaklaştırarak boşlukları kapatır.',
                'video' => "{$cdn}/4EUZZ9EFT6pEAxFB3YXfmB/ce852d509cab6f4c4fd50501c09cd552/video-resources-gap-teeth-timelapse.mp4",
            ],
            [
                'key'   => 'acik',
                'title' => 'Açık kapanış',
                'lead'  => 'Ağız kapalıyken ön dişler birbirine değmez ve arada açıklık kalır.',
                'risks' => ['Isırma ve çiğnemeyi zorlaştırır', 'Konuşmada peltekliğe yol açabilir', 'Arka dişlere fazla yük bindirir'],
                'fix'   => 'Plaklar dişlerin dikey konumunu ayarlayarak ön dişlerin buluşmasını sağlar.',
                'video' => "{$cdn}/42bCcWscz2ZvC8t1weSNqf/2862efc6ff7acfdd82a3cc03dd49dadb/video-resources-openbite-timelapse.mp4",
            ],
            [
                'key'   => 'caprasik',
                'title' => 'Çapraşık dişler',
                'lead'  => 'Çene kavsinde yeterli yer olmadığında dişler üst üste biner veya dönerek sıralanır.',
                'risks' => ['Dişler arası temizliği zorlaştırır', 'Çürük ve diş eti hastalığı riskini artırır', 'Dişlerde düzensiz aşınmaya yol açabilir'],
                'fix'   => 'Kişiye özel plaklar her diş için planlanan küçük hareketlerle dişlere yer açar ve onları düzgün bir sıraya yerleştirir.',
                'video' => "{$cdn}/3D5olWXeBTWARkBRSewN53/33cdf307257e25c4c7b38702fadac240/video-resources-crowded-teeth-timelapse.mp4",
            ],
            [
                'key'   => 'sut',
                'title' => 'Süt dişleri ve daimi dişler',
                'lead'  => 'Süt ve kalıcı dişlerin bir arada bulunduğu dönemde (6–10 yaş) çene gelişimi yönlendirilebilir.',
                'risks' => ['Kalıcı dişler için yer kalmayabilir', 'Kapanış bozuklukları ilerleyebilir', 'İleride daha kapsamlı tedavi gerekebilir'],
                'fix'   => 'Çocuklara özel şeffaf plaklar, gelişim döneminde dişlere ve çeneye erken müdahale ederek ileride oluşabilecek sorunları azaltır.',
                'video' => "{$cdn}/1t7R5ddV6ysE0KntIzEKNH/1a610dbb3c39bbdd6f825f242cb50eff/video-resources-baby-and-permanent-teeth-time-lapse.mp4",
            ],
            [
                'key'   => 'duzgun',
                'title' => 'Genellikle daha düzgün dişler',
                'lead'  => 'Dişler genel olarak düzgün olsa da küçük kaymalar, dönmeler veya hafif çapraşıklıklar bulunur.',
                'risks' => ['Küçük kaymalar zamanla artabilir', 'Gülüş simetrisini bozabilir', 'Eski ortodonti tedavisi sonrası nüks görülebilir'],
                'fix'   => 'Kısa süreli şeffaf plak tedavisiyle küçük düzensizlikler hızlıca giderilir.',
                'video' => "{$cdn}/6KyoPWSRmRuFrkSokhJYdf/0c287d2508259627ca39b6c7677aaf96/video-resources-straighter-teeth-timelapse.mp4",
            ],
        ];

        ## ------- INVISALIGN NEDİR (genel tedavi bilgileri) -------- ##
        $this->facts = [
            ['value' => '20–22', 'unit' => 'saat', 'label' => 'Günlük kullanım süresi'],
            ['value' => '7–14',  'unit' => 'gün',  'label' => 'Yeni plağa geçiş aralığı'],
            ['value' => '6–18',  'unit' => 'ay',   'label' => 'Ortalama tedavi süresi'],
        ];

        ## ------- AVANTAJLAR -------- ##
        $this->benefits = [
            ['icon' => 'fa-eye-slash',      'img' => 'hero', 'title' => 'Neredeyse görünmez',  'text' => 'Şeffaf plaklar dişlerinizin üzerinde fark edilmez; iş görüşmesinde de düğün fotoğrafında da rahatsınız.'],
            ['icon' => 'fa-hand-sparkles',  'img' => 'aligner-hand', 'title' => 'Çıkarılabilir',       'text' => 'Yemek yerken ve dişlerinizi fırçalarken plakları çıkarırsınız. Yiyecek kısıtlaması yoktur.'],
            ['icon' => 'fa-feather',        'img' => 'aligner-putting', 'title' => 'Konforlu',            'text' => 'Pürüzsüz yüzey; tel batması ve braket kaynaklı yara oluşmaz.'],
            ['icon' => 'fa-cube',           'img' => 'scan-screen', 'title' => 'Öngörülebilir',       'text' => 'Dijital planlama ile dişlerinizin her adımda nasıl hareket edeceğini önceden görürsünüz.'],
            ['icon' => 'fa-soap',           'img' => 'aligner-case', 'title' => 'Hijyenik',            'text' => 'Diş fırçası ve diş ipi kullanımınız değişmez; diş eti sağlığınızı korumak kolaylaşır.'],
            ['icon' => 'fa-calendar-check', 'img' => 'woman-white', 'title' => 'Daha az kontrol',     'text' => 'Tel ayarı olmadığı için kontrol randevuları daha seyrek ve kısadır.'],
        ];

        ## ------- KİMLER İÇİN -------- ##
        $this->audiences = [
            ['icon' => 'fa-child',        'title' => 'Çocuklar',   'age' => '6–10 yaş',
             'text' => 'Süt ve kalıcı dişlerin bir arada olduğu dönemde çene gelişimi yönlendirilebilir.',
             'items' => ['Erken müdahale', 'Yer açma', 'Çocuklara özel plaklar']],
            ['icon' => 'fa-graduation-cap','title' => 'Gençler',   'age' => '11–17 yaş',
             'text' => 'Okul ve sosyal hayatı etkilemeden, fark edilmeden tedavi.',
             'items' => ['Sürmekte olan dişlere uyum', 'Kullanım takip göstergesi', 'Spor ve müzikle uyumlu']],
            ['icon' => 'fa-user-tie',     'title' => 'Yetişkinler', 'age' => '18+ yaş',
             'text' => 'Sağlıklı diş eti ve kemik yapısı olduğu sürece yaş sınırı yoktur.',
             'items' => ['İş hayatında görünmez', 'Eski tedavi sonrası nüks', 'Protez öncesi hazırlık']],
        ];

        ## ------- PLAKLARLA BİR GÜN -------- ##
        $this->dayItems = [
            ['time' => '07:30', 'icon' => 'fa-sun',          'title' => 'Sabah',     'text' => 'Plakları çıkarın, dişlerinizi fırçalayın, plakları durulayıp takın.'],
            ['time' => '08:00', 'icon' => 'fa-mug-hot',      'title' => 'Kahvaltı',  'text' => 'Yemekten önce plakları çıkarın, kabına koyun. Dilediğinizi yiyin.'],
            ['time' => '12:30', 'icon' => 'fa-utensils',     'title' => 'Öğle',      'text' => 'Yemek sonrası ağzınızı çalkalayın veya fırçalayın, plakları geri takın.'],
            ['time' => '19:00', 'icon' => 'fa-glass-water',  'title' => 'Akşam',     'text' => 'Plaklar takılıyken sadece su için; çay, kahve için çıkarın.'],
            ['time' => '23:00', 'icon' => 'fa-moon',         'title' => 'Gece',      'text' => 'Plaklar gece boyunca takılı kalır; tedavinin önemli kısmı uykuda ilerler.'],
        ];

        ## ------- TEDAVİ SONRASI -------- ##
        $this->retention = [
            ['icon' => 'fa-link',         'title' => 'Sabit pekiştirme', 'text' => 'Ön dişlerin iç yüzeyine yapıştırılan ince bir tel, dişlerin eski konumuna dönmesini engeller. Dışarıdan görünmez.'],
            ['icon' => 'fa-moon',         'title' => 'Gece plağı',       'text' => 'Şeffaf pekiştirme plağı, ilk dönem her gece; sonrasında hekiminizin önerdiği sıklıkta kullanılır.'],
            ['icon' => 'fa-stethoscope',  'title' => 'Düzenli kontrol',  'text' => 'Tedavi sonrası belirli aralıklarla yapılan kontrollerle sonucun kalıcılığı takip edilir.'],
        ];

        ## ------- INVISALIGN vs TEL -------- ##
        $this->compareRows = [
            ['label' => 'Görünürlük',            'inv' => 'Neredeyse görünmez',            'tel' => 'Metal veya seramik braketler görünür'],
            ['label' => 'Yemek & içmek',         'inv' => 'Plakları çıkarıp dilediğinizi yersiniz', 'tel' => 'Sert ve yapışkan gıdalar kısıtlı'],
            ['label' => 'Ağız hijyeni',          'inv' => 'Fırça ve diş ipi her zamanki gibi', 'tel' => 'Braket aralarını temizlemek zor'],
            ['label' => 'Konfor',                'inv' => 'Pürüzsüz plastik, tel batması yok', 'tel' => 'Tel ve braket tahrişi olabilir'],
            ['label' => 'Sonucu önceden görme',  'inv' => '3D dijital simülasyon ile',     'tel' => 'Mümkün değil'],
            ['label' => 'Kontrol randevuları',   'inv' => 'Daha seyrek',                    'tel' => 'Daha sık, tel ayarı gerekir'],
        ];

        ## ------- SÜREÇ -------- ##
        $this->steps = [
            ['icon' => 'fa-user-doctor',    'title' => 'Muayene & 3D tarama', 'text' => 'Ölçü kaşığı olmadan dijital ağız içi tarama ile dişlerinizin 3D modeli çıkarılır.'],
            ['icon' => 'fa-cube',           'title' => 'Dijital planlama',    'text' => 'Hekiminiz tedavinizi planlar; dişlerinizin adım adım nasıl hareket edeceğini ekranda birlikte görürsünüz.'],
            ['icon' => 'fa-teeth',          'title' => 'Plaklarınızı takın',  'text' => 'Size özel üretilen plakları günde 20–22 saat takar, genellikle 7–14 günde bir yenisine geçersiniz.'],
            ['icon' => 'fa-face-smile-beam','title' => 'Yeni gülüşünüz',      'text' => 'Tedavi sonunda sonucu korumak için pekiştirme (retainer) aparatları ile takip sürer.'],
        ];

        ## ------- GOOGLE YORUMLARI (Google Haritalar'dan alındı; soyadlar kısaltıldı) -------- ##
        $this->reviews = [
            ['initials' => 'LS', 'name' => 'Laçin S.',    'meta' => '7 yorum · 2 fotoğraf', 'when' => '2 ay önce',
             'text' => 'Plak tedavisine başlamak için uzun araştırmalar sonu en iyi yerin burası olduğuna karar verdim. Fatih hocanın ve çalışanların ilgisi, bütün sorularıma sabırla cevap vermeleri süreci çok kolaylaştırdı. Süreç boyunca olabilecek olumlu olumsuz her şeyi dürüstçe paylaşıyorlar. Ayrıca benim gibi çalışan biriyseniz plak tedavisinde her an ulaşılabilir bir ortodontist bulmak bir şans. Gözünüz kapalı gelebilirsiniz 🌸'],
            ['initials' => 'DK', 'name' => 'Dilara K.',   'meta' => '1 yorum', 'when' => '4 ay önce',
             'text' => 'Tedavimi Fatih hoca Invisalign plak tedavisi ile gerçekleştirdi. Bugün tedavimin sonuna geldik; yamuk olan dişlerim artık dümdüz, gerçekten çok memnun kaldım tüm bu süreçte. Fatih hocanın ve ekibinin güler yüzlü, samimi ve açıklayıcı yaklaşımı, kliniğin temiz ve hijyenik koşulları… Kesinlikle bu kliniği tercih etmeyi herkese öneririm.'],
            ['initials' => 'TK', 'name' => 'Tuğçe K.',    'meta' => '7 yorum', 'when' => '4 ay önce',
             'text' => 'MARPE damak genişletme ve plak tedavime başladım. Tedavi öncesinde bu süreç gözümü biraz korkutuyordu ancak doktorum Fatih Hoca ve asistanı Sude Nur’un ilgisi, profesyonelliği ve güler yüzü sayesinde tüm endişelerim yok oldu. Süreç çok konforlu ilerliyor. Kendinizi güvenle teslim edebileceğiniz harika bir ekip!'],
            ['initials' => 'MB', 'name' => 'M. B.',       'meta' => 'Yerel Rehber · 16 yorum', 'when' => '5 ay önce',
             'text' => 'Bütün ömrü diş hekimleriyle geçmiş biri olarak söylüyorum, şimdiye kadar yaşadığım en iyi diş hekimi muayenesi deneyimiydi. Dürüstlüğü, şeffaflığı ve çözüm odaklılığı ile gönlümü fethettiler. Ayşenur Hanım, Fatih Bey ve klinikteki tüm çalışanlara çok teşekkür ederim.'],
            ['initials' => 'HŞ', 'name' => 'Hilal Ş.',    'meta' => '3 yorum · 1 fotoğraf', 'when' => '7 ay önce',
             'text' => 'Yıllar önce ortodontik tedavim için Fatih Bey ile sürece başlamıştım ve tedavi süreci sonunda çok memnun kaldım. Tedavi boyunca süreci yakından takip etmesi ve her aşamada detaylı şekilde bilgilendirmesi benim için oldukça güven vericiydi. Her zaman güler yüzlü ve ilgili bir ekiple karşılaştım.'],
            ['initials' => 'CK', 'name' => 'Cemile K.',   'meta' => '3 yorum', 'when' => '11 ay önce',
             'text' => 'Doktorlarım Fatih Bey’den ve Ayşenur Hanım’dan çok memnunum. Bütün aileme öncü oldum, şimdi ailecek geliyoruz ve herkes yapılan tedavilerden çok memnun. Bütün ekip olarak mükemmeller, başarıları daim olsun :)'],
            ['initials' => 'ND', 'name' => 'Nur D.',      'meta' => '1 yorum · 4 fotoğraf', 'when' => '2 yıl önce',
             'text' => 'İlkokuldan beri var olan dişçi korkumdan dolayı en öndeki bir dişim daha arkadaydı, alt dişlerim çarpıktı. Gülerken, fotoğraf çekerken sürekli rahatsız hissediyordum. Fatih Hoca’nın ve Ayşenur Hoca’nın işini sevmesi ve profesyonelliği sayesinde tedavime başladım, dişçi koltuğu korkumu aştım. Dişlerimdeki düzelmeyi görmek çok güzel :) Klinik çok temiz, kullanılan materyaller kaliteli.'],
        ];

        ## ------- SIK SORULAN SORULAR -------- ##
        $this->faqItems = [
            ['q' => 'Invisalign tedavisi ne kadar sürer?',
             'a' => 'Vakanın zorluğuna göre değişmekle birlikte çoğu tedavi 6–18 ay arasında tamamlanır. Kesin süre, muayene ve 3D tarama sonrası dijital planlamada netleşir.'],
            ['q' => 'Plaklar ağrı yapar mı?',
             'a' => 'Her yeni plakla birlikte 1–3 gün hafif bir baskı hissi olabilir; bu, dişlerin hareket ettiğini gösterir. Tel ve braket olmadığı için ağız içinde tahriş genellikle yaşanmaz.'],
            ['q' => 'Plaklar konuşmamı etkiler mi?',
             'a' => 'İlk birkaç gün hafif bir peltekleşme olabilir. Dil kısa sürede alışır ve konuşma normale döner.'],
            ['q' => 'Plaklarla yemek yiyebilir miyim?',
             'a' => 'Yemek yerken plakları çıkarırsınız; bu sayede yiyecek kısıtlaması yoktur. Yemekten sonra dişlerinizi fırçalayıp plakları tekrar takmanız yeterlidir.'],
            ['q' => 'Günde kaç saat takmam gerekiyor?',
             'a' => 'Planlanan sonuca ulaşmak için plakların günde 20–22 saat takılması gerekir. Sadece yemek ve temizlik sırasında çıkarılır.'],
            ['q' => 'Invisalign kimler için uygundur?',
             'a' => 'Çapraşıklık, diş arası boşluk ve birçok kapanış bozukluğu olan yetişkin ve gençler için uygundur. Uygunluk; diş eti sağlığı ve vakanın durumuna göre muayenede belirlenir.'],
            ['q' => 'Tedavi ücreti nasıl belirlenir?',
             'a' => 'Ücret; vakanın zorluğuna, gereken plak sayısına ve tedavi süresine göre kişiye özel belirlenir. Muayene sonrası size net bir tedavi planı ve ödeme seçenekleri sunulur.'],
            ['q' => 'Plaklar dışarıdan fark edilir mi?',
             'a' => 'Plaklar şeffaf ve ince olduğu için konuşurken ya da gülerken çoğu zaman fark edilmez. Bazı vakalarda dişlere yapıştırılan küçük, diş renginde tutucular kullanılabilir.'],
            ['q' => 'Ne sıklıkla kontrole gelmem gerekir?',
             'a' => 'Kontroller genellikle 6–10 haftada bir planlanır. Tel ayarı olmadığı için randevular kısa sürer.'],
            ['q' => 'Tedavi bittikten sonra dişlerim eski haline döner mi?',
             'a' => 'Sonucun korunması için tedavi sonrası pekiştirme aparatı (retainer) kullanılır. Önerilen kullanım düzenine uyulduğunda sonuç kalıcı olur.'],
        ];
    }

    public function render()
    {
        $payload = $this->lpPayload($this->seoOverride);

        return view(
            'livewire.invisalign.' . app()->getLocale() . '.index',
            $payload
        )->layout('layouts.app', $payload);
    }
}
