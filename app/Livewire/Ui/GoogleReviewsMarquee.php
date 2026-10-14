<?php

namespace App\Livewire\Ui;
use Livewire\Component;

class GoogleReviewsMarquee extends Component
{
    /** Üst ortalama puan */
    public float $avg = 4.9;

    /** Üst toplam yorum sayısı metni */
    public string $total = '380+ reviews';


    /** Marquee süresi (sn) */
    public int $duration = 44;

    /** Marquee için kaç set tekrar edilsin (2 = seamless) */
    public int $repeat = 2;

    /**
     * Her review:
     * - name
     * - review_count (kullanıcının toplam google yorumu)
     * - rating (1-5)
     * - text
     * - verified (bool)
     */
    public array $reviews = [];

    public function mount(
        ?array $reviews = null,
        float $avg = 4.9,
        string $total = '380+ reviews',
        int $duration = 44,
        int $repeat = 2
    ): void {
        $this->avg = max(0, min(5, $avg));
        $this->total = $total;
        $this->duration = max(10, $duration);
        $this->repeat = max(1, $repeat);

        $this->reviews = $this->normalizeReviews($reviews ?? $this->defaultReviews());
    }


    protected function defaultReviews(): array
    {
        $loc = app()->getLocale();

        return [
            // 1) Matthew (ORİJİNAL)
            [
                'name' => 'Matthew',
                'review_count' => 57,
                'rating' => 5,
                'verified' => true,
                'text' => match ($loc) {
                    'tr' => 'İlk WhatsApp mesajından son kontrol randevusuna kadar tüm süreç çok sorunsuz geçti. Ekip her adımı çok net anlattı, zamanlamayı planladı ve kendimi gerçekten önemsenmiş hissettirdi. Veneer’larım inanılmaz doğal görünüyor — “fazla beyaz” değil, yüzümle mükemmel dengede. Aylar geçmesine rağmen hâlâ iltifat alıyorum ve yemek yerken her şey tamamen normal.',
                    'ru' => 'Весь опыт был безупречным — от первого сообщения в WhatsApp до финального контроля. Команда подробно объясняла каждый шаг, помогала с таймингом и я чувствовал(а) искреннюю заботу. Виниры выглядят очень естественно — не «слишком белые», а идеально сбалансированы с лицом. Даже спустя месяцы я всё ещё получаю комплименты, и есть абсолютно комфортно.',
                    default => 'The entire experience was seamless from the first WhatsApp message to the final check-up. The team explained every step clearly, helped with timing, and made me feel genuinely cared for. My veneers look incredibly natural — not “too white”, just perfectly balanced with my face. Even months later, I’m still getting compliments, and eating feels completely normal.',
                },
            ],

            // 2) Sophie (ORİJİNAL)
            [
                'name' => 'Sophie',
                'review_count' => 12,
                'rating' => 5,
                'verified' => true,
                'text' => match ($loc) {
                    'tr' => 'Son derece profesyonel bir ekip ve çok güzel bir klinik. Kendimi güvende ve bilgilendirilmiş hissettim; sonuçlar beklentilerimin de ötesindeydi.',
                    'ru' => 'Очень профессиональная команда и прекрасная клиника. Я чувствовал(а) себя в безопасности и хорошо информирован(а), а результат превзошёл ожидания.',
                    default => 'Super professional team and a beautiful clinic. I felt safe, informed, and the results exceeded my expectations.',
                },
            ],

            // 3) Helen (ORİJİNAL)
            [
                'name' => 'Helen',
                'review_count' => 4,
                'rating' => 5,
                'verified' => true,
                'text' => match ($loc) {
                    'tr' => 'Planlama ve iletişimi çok beğendim. Her şey zamanında ilerledi ve tedavi sonrası bakım talimatları çok netti.',
                    'ru' => 'Очень понравились планирование и коммуникация. Всё шло по расписанию, а рекомендации по уходу после лечения были очень понятными.',
                    default => 'Loved the planning and communication. Everything ran on time, and the aftercare instructions were very clear.',
                },
            ],

            // 4) Yeni
            [
                'name' => 'Daniel',
                'review_count' => 23,
                'rating' => 5,
                'verified' => true,
                'text' => match ($loc) {
                    'tr' => 'Süreç baştan sona çok şeffaftı. Ne yapılacağını ve kaç gün süreceğini net bir şekilde bildim. Sonuçlar doğal ve çok başarılı.',
                    'ru' => 'Процесс был полностью прозрачным: я заранее понимал(а), что будет сделано и сколько времени это займет. Результат очень естественный.',
                    default => 'The process was very transparent. I knew exactly what would be done and how long it would take. The result looks natural and feels great.',
                },
            ],

            // 5) Yeni
            [
                'name' => 'Emily',
                'review_count' => 9,
                'rating' => 5,
                'verified' => true,
                'text' => match ($loc) {
                    'tr' => 'Benim için en önemlisi doğallıktı ve tam istediğim gibi oldu. Renk ve form yüzümle çok uyumlu.',
                    'ru' => 'Для меня была важна естественность — цвет и форма идеально подошли к лицу. Очень довольна.',
                    default => 'Natural-looking results were my priority, and they nailed it. The shade and shape fit my face perfectly.',
                },
            ],

            // 6) Yeni
            [
                'name' => 'Oliver',
                'review_count' => 31,
                'rating' => 5,
                'verified' => true,
                'text' => match ($loc) {
                    'tr' => 'Klinik çok temiz, ekip çok ilgiliydi. Tedavi sonrası destek de gerçekten çok iyiydi; her soruma hızlı yanıt aldım.',
                    'ru' => 'Клиника очень чистая, команда внимательная. Поддержка после лечения была отличной — на вопросы отвечали быстро.',
                    default => 'The clinic was spotless and the team was very attentive. Aftercare support was excellent and they replied quickly whenever I had a question.',
                },
            ],
        ];
    }


    protected function normalizeReviews(array $reviews): array
    {
        return array_values(array_map(function ($r) {
            $name = (string)($r['name'] ?? 'Anonymous');
            $count = (int)($r['review_count'] ?? 0);
            $rating = (int)($r['rating'] ?? 5);
            $rating = max(1, min(5, $rating));

            return [
                'name' => $name,
                'review_count' => max(0, $count),
                'rating' => $rating,
                'verified' => (bool)($r['verified'] ?? false),
                'text' => (string)($r['text'] ?? ''),
            ];
        }, $reviews));
    }

    public function initials(string $name): string
    {
        $name = trim($name);
        if ($name === '') return 'A';

        $parts = preg_split('/\s+/', $name) ?: [];
        $first = $parts[0] ?? '';
        $last  = $parts[count($parts) - 1] ?? '';

        $ini = mb_substr($first, 0, 1) . mb_substr($last, 0, 1);
        $ini = mb_strtoupper(trim($ini));

        return $ini !== '' ? $ini : 'A';
    }

    /** review_count arttıkça yıldız rengi koyulaşsın */
    public function starShadeByReviewCount(int $count): array
    {
        // 5 yıldız için copper tonları (açık -> koyu)
        if ($count >= 41) return ['text-brand-100', 'text-brand-200', 'text-brand-300', 'text-brand-400', 'text-brand-600'];
        if ($count >= 16) return ['text-brand-200','text-brand-300','text-brand-400','text-brand-500','text-brand-600'];
        if ($count >= 6)  return ['text-brand-100','text-brand-200','text-brand-300','text-brand-400','text-brand-500'];
        return ['text-brand-100','text-brand-100','text-brand-200','text-brand-200','text-brand-300'];
    }

    public function render()
    {
        return view('livewire.Ui.google-reviews-marquee');
    }
}
