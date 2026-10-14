<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_type',
        'source',
        'locale',
        'geo_country',
        'geo_region',
        'geo_city',

        'name',
        'phone',
        'email',
        'message',

        'ip',
        'user_agent',
        'details',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    /**
     * Mail query'lerinde select için tek kaynak
     */
    public const MAIL_COLUMNS = [
        'id',
        'form_type',
        'source',
        'locale',
        'name',
        'phone',
        'email',
        'message',
        'details',
        'geo_country',
        'geo_region',
        'geo_city',
        'ip',
    ];

    /** Form türlerinin okunur adları (mail / panel) */
    public const FORM_LABELS = [
        'simple'     => 'Randevu Formu',
        'step'       => 'Diş Analizi Formu',
        'Lucky Spin' => 'Şans Çarkı',
    ];

    /** Details anahtarlarının Türkçe etiketleri */
    private const DETAIL_LABELS = [
        'ilgilenilen_durum' => 'İlgilenilen durum',
        'kimin_icin'        => 'Kimin için',
        'kvkk_onay'         => 'KVKK onayı',
        'Award'             => 'Kazanılan hediye',
        'Source'            => 'Kaynak',
        'ref'               => 'Geldiği sayfa',
    ];

    /** +905321234567 → +90 532 123 45 67 (TR); diğer ülkeler olduğu gibi */
    public function phonePretty(): string
    {
        $p = (string) $this->phone;
        if (preg_match('/^\+90(\d{3})(\d{3})(\d{2})(\d{2})$/', $p, $m)) {
            return "+90 {$m[1]} {$m[2]} {$m[3]} {$m[4]}";
        }
        return $p;
    }

    public function formLabel(): string
    {
        return self::FORM_LABELS[$this->form_type] ?? ucfirst((string) ($this->form_type ?: 'Form'));
    }

    /**
     * Mail konu satırı (tek yer): "Yeni Başvuru · Randevu Formu · Ayşe Yılmaz | Kahraman Ortodonti"
     */
    public function mailSubject(string $brand): string
    {
        return 'Yeni Başvuru · ' . $this->formLabel() . ' · ' . ($this->name ?: '-') . " | {$brand}";
    }

    /**
     * Details'i mail/admin/export için temiz + okunur döner
     * - boşları atar
     * - key'i label yapar
     * - value'yu string'e çevirir
     */
    public function detailsList(): array
    {
        $details = $this->details;

        if (!is_array($details) || $details === []) {
            return [];
        }

        $out = [];

        foreach ($details as $k => $v) {
            if ($v === null || $v === '') continue;
            if (is_array($v) && $v === []) continue;

            $out[$this->labelKey((string) $k)] = $this->stringValue($v);
        }

        return $out;
    }

    private function labelKey(string $key): string
    {
        return self::DETAIL_LABELS[$key] ?? mb_convert_case(str_replace(['_', '-'], ' ', $key), MB_CASE_TITLE, 'UTF-8');
    }

    private function stringValue(mixed $value): string
    {
        if (is_bool($value)) return $value ? 'Evet' : 'Hayır';
        if (is_array($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return (string) $value;
    }
}
