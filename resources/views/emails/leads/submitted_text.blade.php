YENİ BAŞVURU — {{ $s->formLabel() }}
{{ $brand }}

Ad soyad: {{ $s->name ?? '-' }}
Telefon: {{ $s->phonePretty() ?: '-' }}
@if(!empty($s->email))
E-posta: {{ $s->email }}
@endif
@php($details = $s->detailsList())
@if(!empty($details))

Başvuru detayları:
@foreach($details as $label => $value)
- {{ $label }}: {{ $value }}
@endforeach
@endif
@if(!empty($s->message))

Mesaj:
{{ $s->message }}
@endif

Kayıt no: #{{ $s->id }}
Konum: {{ collect([$s->geo_city, $s->geo_region, $s->geo_country])->filter()->unique()->implode(', ') ?: '-' }}
IP: {{ $s->ip ?? '-' }}
