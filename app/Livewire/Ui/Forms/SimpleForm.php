<?php

namespace App\Livewire\Ui\Forms;

use App\Pipelines\LeadPipeline;
use App\Rules\RealEmail;
use App\Rules\RealName;
use App\Rules\RealPhone;
use App\Traits\RedirectsToThankYou;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class SimpleForm extends Component
{
    use RedirectsToThankYou;

    public bool $success = false;
    public bool $submitFailed = false;
    public ?string $submitError = null;

    public string $variant = 'dark';
    public string $layout  = 'vertical';
    public string $pageTitle = 'unknown';

    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $message = '';

    public string $company = '';

    // Lead formu: e-posta opsiyonel, KVKK onayı zorunlu, ilgilenilen durum (vaka) seçilebilir
    public bool $emailRequired = true;
    public bool $requireConsent = false;
    public bool $kvkk = false;
    public string $topic = '';
    public bool $withTopic = true; // false: "ilgilendiğiniz durum" alanı gösterilmez (açılır pencereler)
    public string $formKey = '';
    public ?string $submitLabel = null; // boşsa forms.consultation.dm-submit

    public function mount(
        ?string $variant = null,
        ?string $layout = null,
        ?string $pageTitle = null,
        ?bool $emailRequired = null,
        ?bool $requireConsent = null,
        ?string $topic = null,
        ?string $formKey = null,
        ?bool $withTopic = null,
        ?string $submitLabel = null,
    ): void
    {
        if ($variant)  $this->variant = $variant;
        if ($layout)   $this->layout  = $layout;
        if ($emailRequired !== null)  $this->emailRequired  = $emailRequired;
        if ($requireConsent !== null) $this->requireConsent = $requireConsent;
        if ($topic)    $this->topic   = $topic;
        if ($withTopic !== null) $this->withTopic = $withTopic;
        if ($submitLabel) $this->submitLabel = $submitLabel;
        $this->formKey = $formKey ?: $this->getId();

        if ($pageTitle) {
            $this->pageTitle = $pageTitle;
        } else {
            $segments = request()->segments();
            $this->pageTitle = end($segments) ?: 'unknown';
        }
    }

    protected function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'min:2', 'max:50', new RealName()],
            'phone'   => ['required', 'string', new RealPhone()],
            'email'   => [$this->emailRequired ? 'required' : 'nullable', 'email:rfc,strict', 'max:120', new RealEmail()],
            'message' => ['nullable', 'string', 'max:1000'],
            'topic'   => ['nullable', 'string', 'max:120'],
            'kvkk'    => $this->requireConsent ? ['accepted'] : [],
        ];
    }

    private function buildPayload(array $validated): array
    {
        return [
            'name'    => $validated['name'],
            'phone'   => $validated['phone'],
            'email'   => $validated['email'] ?? null,
            'message' => $validated['message'] ?? null,
            'ilgilenilen_durum' => ($validated['topic'] ?? '') ?: null,
            'kvkk_onay' => $this->requireConsent ? 'Evet' : null,
            'ref'     => request()->headers->get('referer'),
        ];
    }

    public function submit(): mixed
    {
        if ($this->company !== '') return null;

        $this->success = false;
        $this->submitFailed = false;
        $this->submitError = null;

        $this->resetErrorBag('form');

        $this->phone = preg_replace('/(?!^\+)\D+/', '', $this->phone ?? '');

        try {
            $validated = $this->validate();

            $payload = $this->buildPayload($validated);
            LeadPipeline::handle('simple', $payload);

            $waMessage = $this->buildLeadWhatsAppMessage('simple', [
                'name'    => $validated['name']    ?? '',
                'phone'   => $validated['phone']   ?? '',
                'email'   => $validated['email']   ?? '',
                'message' => trim(implode("\n", array_filter([
                    ($validated['topic'] ?? '') ? __('forms.consultation.fields.topic') . ': ' . $validated['topic'] : null,
                    $validated['message'] ?? null,
                ]))),
            ]);

            $this->reset(['name', 'phone', 'email', 'message', 'kvkk']);
            $this->resetValidation();
            $this->success = true;

            // Yeni sekmede WhatsApp — karşılama + form bilgileri + kullanıcı mesajı
            $this->openWhatsAppTab($waMessage);

            // ✅ tek yerden otomatik redirect
             return $this->redirectToThankYou($payload);

        } catch (ValidationException $e) {
            $this->addError('form', __('validation.check_marked_fields'));
            throw $e;

        } catch (\Throwable $e) {
            report($e);
            $this->submitFailed = true;
            $this->submitError = config('app.debug')
                ? class_basename($e) . ': ' . $e->getMessage()
                : null;
            return null;
        }
    }

    public function render()
    {
        return view('livewire.Ui.forms.simple-form', [
            'topics'  => __('forms.consultation.topics'),
            'variant' => $this->variant,
            'layout'  => $this->layout,
        ]);
    }
}
