<?php

namespace App\Livewire\Ui\Forms;
use App\Pipelines\LeadPipeline;
use App\Rules\RealName;
use App\Rules\RealPhone;
use App\Traits\RedirectsToThankYou;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class LuckySpin extends Component
{

    use RedirectsToThankYou;
    public string $name = '';
    public string $phone = '';

    /** UI state */
    public bool $spun = false;        // çark çevrildi mi (ödül seçildi mi)
    public bool $spinDone = false;    // animasyon bitti mi (form gizle -> sonuç göster)
    public ?array $result = null;     // ['key'=>..., 'label'=>...]

    // Lead spin() anında kaydedilir; animasyon bitince sadece teşekkür sayfasına geçilir (Zürih akışı).
    public ?array $payload = null;
    public ?string $waMessage = null;

    private function prizes(): array
    {
        // TODO: Ödüller klinikle teyit edilecek
        // Tek renk ailesi: vurgu renginin iki tonu dönüşümlü
        $dark = ['--color-brand-700', '--color-brand-900'];
        $blue = ['--color-brand-500', '--color-brand-700'];

        return [
            ['key'=>'pct10',     'label'=>__('forms.lucky-spin.pct10'),     'weight'=>25, 'grad'=>$dark],
            ['key'=>'cleaning',  'label'=>__('forms.lucky-spin.cleaning'),  'weight'=>20, 'grad'=>$blue],
            ['key'=>'pct15',     'label'=>__('forms.lucky-spin.pct15'),     'weight'=>10, 'grad'=>$dark],
            ['key'=>'retainer',  'label'=>__('forms.lucky-spin.retainer'),  'weight'=>8,  'grad'=>$blue],
            ['key'=>'pct5',      'label'=>__('forms.lucky-spin.pct5'),      'weight'=>25, 'grad'=>$dark],
            ['key'=>'whitening', 'label'=>__('forms.lucky-spin.whitening'), 'weight'=>5,  'grad'=>$blue],
            ['key'=>'pct20',     'label'=>__('forms.lucky-spin.pct20'),     'weight'=>3,  'grad'=>$dark],
            ['key'=>'kit',       'label'=>__('forms.lucky-spin.kit'),       'weight'=>4,  'grad'=>$blue],
        ];

    }

    private function theme(): array
    {
        return [
            'rim_stroke'  => '#ffffff',
            'dot_color'   => '#000000',
            'cap_outer'   => '#ffffff',
            'cap_inner'   => '#765538',
            'pin_grad'    => ['#ecd3a2', '#c9973f', '#a8772e'], // bal tonu (detay rengi)
            'text_fill'   => 'rgba(255,255,255,0.96)',
            'text_stroke' => 'rgba(0,0,0,0.18)',
            'divider'     => 'rgba(255,255,255,0.14)',
        ];
    }

    protected function rules(): array
    {
        return [
            'name'  => ['required', 'string', 'min:2', 'max:80', new RealName()],
            'phone' => ['required', 'string', new RealPhone()],
        ];
    }

    public function spin(): void
    {
        // normalize
        $this->phone = preg_replace('/(?!^\+)\D+/', '', $this->phone ?? '');

        $validated = $this->validate();

        // günlük limit (istersen kaldırırız)
        $limitKey = $this->spinLimitKey($validated['phone']);
        if (Cache::has($limitKey)) {
            throw ValidationException::withMessages([
                'phone' => __('validation.spin.phone_used'),
            ]);
        }

        $prizes  = $this->prizes();
        $picked  = $this->pickWeighted($prizes);
        $index   = (int) collect($prizes)->values()->search(fn ($p) => $p['key'] === $picked['key']);
        if ($index < 0) $index = 0;

        // state
        $this->result = ['key' => $picked['key'], 'label' => $picked['label']];
        $this->spun = true;
        $this->spinDone = false; // ✅ form animasyon bitene kadar kalsın

        // Lead'i hemen kaydet — kullanıcı animasyon sırasında sayfayı kapatsa da kaybolmasın
        try {
            $this->payload = $this->buildPayload($validated);
            LeadPipeline::handle('Lucky Spin', $this->payload);

            $this->waMessage = $this->buildLeadWhatsAppMessage('spin', [
                'name'  => $validated['name'],
                'phone' => $validated['phone'],
                'prize' => $picked['label'],
            ]);
        } catch (\Throwable $e) {
            report($e);
        }

        Cache::put($limitKey, true, now()->addDay());

        // wheel animasyonu (JS dinliyor)
        $this->dispatch(
            'spinResult',
            index: $index,
            label: $picked['label'],
            sourceId: $this->getId()
        );

    }

    /**
     * JS animasyon bitince bunu çağıracak:
     * Livewire.dispatch('spinDone')
     */






    #[On('luckySpinLocked')]
    public function syncOffer(array $result, ?string $sourceId = null): void
    {
        if ($sourceId === $this->getId()) return; // kendi event'i ise dokunma

        $this->spun = true;
        $this->result = $result;
        $this->spinDone = true; // ✅ diğer formlarda da sonucu göster
    }



    private function pickWeighted(array $items): array
    {
        $items = array_values(array_filter($items, fn ($i) => (int)($i['weight'] ?? 0) > 0));

        $sum = array_sum(array_map(fn ($i) => (int) $i['weight'], $items));
        if ($sum <= 0) {
            return ['key' => 'none', 'label' => 'No prize', 'weight' => 1];
        }

        $r = random_int(1, $sum);
        $acc = 0;

        foreach ($items as $item) {
            $acc += (int) $item['weight'];
            if ($r <= $acc) return $item;
        }

        return $items[array_key_last($items)];
    }

    private function spinLimitKey(string $phone): string
    {
        $normalized = preg_replace('/(?!^\+)\D+/', '', $phone) ?: $phone;
        return 'luckyspin:' . md5($normalized . '|' . now()->toDateString());
    }

    private function buildPayload(array $validated): array
    {
        return [
            // core
            'name'  => $validated['name'],
            'phone' => $validated['phone'],

            // meta
            'ref'   => request()->headers->get('referer'),

            // ✅ SADECE DETAILS
            'details' => array_filter([
                'Award'  => $this->result['label'] ?? null, // %10 Discount
                'Source' => 'Şans Çarkı',
            ], fn ($v) => $v !== null && $v !== ''),
        ];
    }

    /**
     * JS animasyon bitince çağırır: Livewire.dispatch('spinDone', { sourceId })
     */
    #[On('spinDone')]
    public function markSpinDone(?string $sourceId = null): void
    {
        if ($sourceId && $sourceId !== $this->getId()) return;
        if (! $this->result) return;

        $this->spinDone = true;

        // Sayfadaki diğer çark formları da sonucu göstersin
        $this->dispatch('luckySpinLocked', result: $this->result, sourceId: $this->getId())->to(self::class);

        // Sonuç kartı kısa bir süre görünsün, sonra teşekkür sayfasına geç
        $this->js('setTimeout(() => $wire.finish(), 2400)');
    }

    public function finish(): mixed
    {
        if (! $this->spinDone || ! $this->payload) return null;

        $this->openWhatsAppTab($this->waMessage);

        return $this->redirectToThankYou($this->payload);
    }

    public function render()
    {
        return view('livewire.Ui.forms.lucky-spin', [
            'prizes' => $this->prizes(),
            'theme'  => $this->theme(),
        ]);
    }
}
