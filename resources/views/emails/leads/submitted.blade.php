{{-- Yeni başvuru maili — Kahraman Ortodonti. Mail programları için tablo düzeni + satır içi stil. --}}
@php
    $navy   = '#4e3826';
    $navy2  = '#765538';
    $gold   = '#c9973f';
    $muted  = '#6b7280';
    $line   = '#e7e9ef';

    $phoneDigits = preg_replace('/\D+/', '', (string) $s->phone);
    $waLink      = $phoneDigits ? 'https://wa.me/' . $phoneDigits : null;
    $details     = $s->detailsList();
    $refUrl      = $details['Geldiği sayfa'] ?? null;
    unset($details['Geldiği sayfa']);
    $location    = collect([$s->geo_city, $s->geo_region, $s->geo_country])->filter()->unique()->implode(', ');
    $sentAt      = now()->timezone('Europe/Istanbul')->format('d.m.Y · H:i');
@endphp
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>{{ $subject }}</title>
</head>
<body style="margin:0;padding:0;background:#f2f4f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;color:#111827;-webkit-font-smoothing:antialiased;">

<div style="display:none;max-height:0;overflow:hidden;opacity:0;">
    {{ $s->formLabel() }}: {{ $s->name }} · {{ $s->phonePretty() }}
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f2f4f8;padding:28px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;">

                {{-- ÜST: lacivert marka şeridi --}}
                <tr>
                    <td style="background:{{ $navy }};background-image:linear-gradient(135deg,{{ $navy }} 0%,{{ $navy2 }} 100%);border-radius:18px 18px 0 0;padding:26px 28px 24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="vertical-align:middle;">
                                    <table role="presentation" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="vertical-align:middle;padding-right:12px;">
                                                <img src="{{ asset('img/mail/mark-white.png') }}" width="30" height="37" alt="" style="display:block;border:0;">
                                            </td>
                                            <td style="vertical-align:middle;">
                                                <div style="font-size:17px;font-weight:700;letter-spacing:4px;color:#ffffff;line-height:1;">KAHRAMAN</div>
                                                <div style="margin-top:5px;font-size:9px;letter-spacing:3px;color:#e7d6c2;line-height:1;">ORTODONTİ</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td align="right" style="vertical-align:middle;">
                                    <span style="display:inline-block;padding:6px 12px;border-radius:999px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);font-size:11px;font-weight:600;letter-spacing:1px;color:#ecd3a2;text-transform:uppercase;">
                                        {{ $s->formLabel() }}
                                    </span>
                                </td>
                            </tr>
                        </table>

                        <div style="margin-top:26px;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#e2b979;">Yeni başvuru</div>
                        <div style="margin-top:6px;font-size:26px;line-height:1.25;font-weight:600;color:#ffffff;">{{ $s->name }}</div>
                        <div style="margin-top:6px;font-size:13px;color:#e7d6c2;">{{ $sentAt }}@if($s->source && $s->source !== 'unknown') · {{ $s->source }}@endif</div>
                    </td>
                </tr>

                {{-- GÖVDE --}}
                <tr>
                    <td style="background:#ffffff;padding:24px 28px 8px;border-left:1px solid {{ $line }};border-right:1px solid {{ $line }};">

                        {{-- Hızlı aksiyonlar --}}
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="50%" style="padding-right:6px;">
                                    <a href="tel:{{ $s->phone }}" style="display:block;text-align:center;padding:13px 10px;border-radius:12px;background:{{ $navy }};color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;">
                                        &#9742;&nbsp; Hemen ara
                                    </a>
                                </td>
                                <td width="50%" style="padding-left:6px;">
                                    @if($waLink)
                                        <a href="{{ $waLink }}" style="display:block;text-align:center;padding:13px 10px;border-radius:12px;background:#25D366;color:#ffffff;font-size:14px;font-weight:600;text-decoration:none;">
                                            WhatsApp’tan yaz
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        {{-- İletişim bilgileri --}}
                        <div style="margin-top:26px;font-size:11px;font-weight:700;letter-spacing:1.6px;text-transform:uppercase;color:{{ $muted }};">İletişim bilgileri</div>
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;border:1px solid {{ $line }};border-radius:12px;border-collapse:separate;">
                            @foreach(array_filter([
                                'Ad soyad' => $s->name,
                                'Telefon'  => $s->phonePretty(),
                                'E-posta'  => $s->email,
                            ]) as $label => $value)
                                <tr>
                                    <td style="padding:13px 16px;font-size:13px;color:{{ $muted }};width:34%;{{ $loop->last ? '' : "border-bottom:1px solid {$line};" }}">{{ $label }}</td>
                                    <td style="padding:13px 16px;font-size:15px;font-weight:600;color:{{ $navy }};{{ $loop->last ? '' : "border-bottom:1px solid {$line};" }}">
                                        @if($label === 'Telefon')
                                            <a href="tel:{{ $s->phone }}" style="color:{{ $navy }};text-decoration:none;">{{ $value }}</a>
                                        @elseif($label === 'E-posta')
                                            <a href="mailto:{{ $value }}" style="color:{{ $navy }};text-decoration:none;">{{ $value }}</a>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        {{-- Başvuru detayları --}}
                        @if(!empty($details) || $s->message)
                            <div style="margin-top:24px;font-size:11px;font-weight:700;letter-spacing:1.6px;text-transform:uppercase;color:{{ $muted }};">Başvuru detayları</div>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px;background:#f7f8fb;border-radius:12px;">
                                @foreach($details as $label => $value)
                                    <tr>
                                        <td style="padding:11px 16px;font-size:13px;color:{{ $muted }};width:34%;">{{ $label }}</td>
                                        <td style="padding:11px 16px;font-size:14px;color:#111827;">
                                            @if($label === 'Kazanılan hediye')
                                                <span style="display:inline-block;padding:3px 10px;border-radius:999px;background:#fbf3e4;color:#8a5f22;font-weight:600;">{{ $value }}</span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if($s->message)
                                    <tr>
                                        <td colspan="2" style="padding:11px 16px 14px;font-size:14px;line-height:1.6;color:#374151;">
                                            <span style="display:block;font-size:13px;color:{{ $muted }};margin-bottom:4px;">Mesaj</span>
                                            {!! nl2br(e($s->message)) !!}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        @endif

                        {{-- Teknik bilgiler --}}
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:22px;border-top:1px solid {{ $line }};">
                            <tr>
                                <td style="padding:14px 0 18px;font-size:12px;line-height:1.7;color:#9ca3af;">
                                    Kayıt no: #{{ $s->id }}
                                    @if($location) &nbsp;·&nbsp; Konum: {{ $location }}@endif
                                    @if($s->ip) &nbsp;·&nbsp; IP: {{ $s->ip }}@endif
                                    @if($refUrl)<br>Sayfa: <a href="{{ $refUrl }}" style="color:#9ca3af;">{{ \Illuminate\Support\Str::limit($refUrl, 70) }}</a>@endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                {{-- ALT --}}
                <tr>
                    <td style="background:#ffffff;border:1px solid {{ $line }};border-top:0;border-radius:0 0 18px 18px;padding:0 28px 22px;">
                        <div style="height:3px;border-radius:3px;background:{{ $gold }};width:40px;"></div>
                        <div style="margin-top:12px;font-size:12px;line-height:1.6;color:#9ca3af;">
                            Bu mail {{ $brand }} web sitesindeki formdan otomatik gönderilmiştir. Hastaya en kısa sürede dönüş yapılması önerilir.
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
