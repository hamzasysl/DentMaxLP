{{-- Logo işaretinin bölüm kenarlarında çok silik (~%3) filigranı.
     Bölüm: relative isolate overflow-clip olmalı. Örn: <x-mark-watermark class="-right-24 top-10 h-[420px]" /> --}}
<x-logo-mark {{ $attributes->class(['pointer-events-none absolute -z-10 hidden w-auto select-none md:block']) }}
             style="--logo-ink: var(--color-brand-900); --logo-accent: var(--color-brand-900); opacity: .035;" />
