<?php

namespace App\Livewire\Ui\Forms;

use App\Pipelines\LeadPipeline;
use App\Rules\RealEmail;
use App\Rules\RealName;
use App\Rules\RealPhone;
use App\Traits\RedirectsToThankYou;
use Livewire\Component;

/**
 * Ücretsiz diş analizi — 3 adımlı form (Zürih LP'deki akış, Invisalign'a uyarlandı)
 *   1) Kimin için   2) Gülüşteki durum (Invisalign ısırık ikonları)   3) İletişim + KVKK
 */
class StepForm extends Component
{
    use RedirectsToThankYou;

    public int $step = 1;

    public bool $success = false;
    public bool $submitFailed = false;
    public ?string $submitError = null;

    // DETAILS
    public ?string $patient = null;   // self | child
    public ?string $condition = null; // ısırık durumu anahtarı

    // CORE
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public bool $kvkk = false;

    public const PATIENTS = [
        'self'  => 'Kendim için',
        'child' => 'Çocuğum için',
    ];

    public const CONDITIONS = [
        'caprasik' => 'Çapraşık Dişler',
        'bosluk'   => 'Diş Arası Boşluk',
        'derin'    => 'Derin Kapanış',
        'ters'     => 'Ters Kapanış',
        'capraz'   => 'Çapraz Kapanış',
        'acik'     => 'Açık Kapanış',
        'sut'      => 'Karma Dişlenme',
        'duzgun'   => 'Küçük Düzeltme',
    ];

    /* ---------------- VALIDATION ---------------- */

    protected function rules(): array
    {
        return [
            'patient'   => $this->step === 1 ? ['required', 'in:' . implode(',', array_keys(self::PATIENTS))] : [],
            'condition' => $this->step === 2 ? ['required', 'in:' . implode(',', array_keys(self::CONDITIONS))] : [],
            'name'      => $this->step === 3 ? ['required', 'min:2', 'max:50', new RealName()] : [],
            'phone'     => $this->step === 3 ? ['required', 'string', new RealPhone()] : [],
            'email'     => $this->step === 3 ? ['required', 'email:rfc,strict', 'max:120', new RealEmail()] : [],
            'kvkk'      => $this->step === 3 ? ['accepted'] : [],
        ];
    }

    protected function messages(): array
    {
        return [
            'patient.required'   => 'Lütfen bir seçim yapın.',
            'condition.required' => 'Lütfen size en yakın durumu seçin.',
        ];
    }

    /* ---------------- FLOW ---------------- */

    public function nextStep(): void
    {
        $this->phone = preg_replace('/(?!^\+)\D+/', '', $this->phone ?? '');
        $this->validate();
        $this->step = min(3, $this->step + 1);
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function setPatient(string $value): void
    {
        $this->patient = $value;
        $this->resetValidation('patient');
        if ($this->step === 1) $this->nextStep();
    }

    public function setCondition(string $value): void
    {
        $this->condition = $value;
        $this->resetValidation('condition');
        if ($this->step === 2) $this->nextStep();
    }

    /* ---------------- SUBMIT ---------------- */

    public function submit(): mixed
    {
        $this->submitFailed = false;
        $this->submitError = null;
        $this->success = false;

        $this->phone = preg_replace('/(?!^\+)\D+/', '', $this->phone ?? '');
        $this->validate();

        $payload = [
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'details' => array_filter([
                'kimin_icin'        => self::PATIENTS[$this->patient] ?? null,
                'ilgilenilen_durum' => self::CONDITIONS[$this->condition] ?? null,
                'kvkk_onay'         => 'Evet',
                'ref'               => request()->headers->get('referer'),
            ]),
        ];

        try {
            LeadPipeline::handle('step', $payload);
        } catch (\Throwable $e) {
            report($e);
            $this->submitFailed = true;
            $this->submitError = config('app.debug') ? class_basename($e) . ': ' . $e->getMessage() : null;
            return null;
        }

        $this->success = true;

        $this->openWhatsAppTab($this->buildLeadWhatsAppMessage('step', [
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'message' => implode("\n", array_filter([
                ($p = self::PATIENTS[$this->patient] ?? null) ? 'Kimin için: ' . $p : null,
                ($c = self::CONDITIONS[$this->condition] ?? null) ? 'Durum: ' . $c : null,
            ])),
        ]));

        return $this->redirectToThankYou($payload);
    }

    /* ---------------- UI ---------------- */

    public function getProgressProperty(): int
    {
        return [1 => 28, 2 => 62, 3 => 100][$this->step] ?? 28;
    }

    public function render()
    {
        return view('livewire.Ui.forms.step-form', [
            'patients'   => self::PATIENTS,
            'conditions' => self::CONDITIONS,
        ]);
    }
}
