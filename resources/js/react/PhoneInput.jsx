import { useEffect, useMemo, useRef, useState } from 'react';
import { createPortal } from 'react-dom';
import { AsYouType, getCountryCallingCode, parsePhoneNumberFromString } from 'libphonenumber-js';
import { COUNTRIES, PRIORITY_COUNTRY_CODES, countryFlag } from './countries.js';
import { cn } from './cn.js';
import { isRealisticPhone } from './phoneHeuristics.js';

const COUNTRY_OPTIONS = (() => {
    const rows = COUNTRIES.map((c) => {
        let d = '';
        try { d = getCountryCallingCode(c.code); } catch { /* no dial */ }
        return d ? { code: c.code, name: c.name, dial: d } : null;
    }).filter(Boolean);

    const rank = (code) => {
        const i = PRIORITY_COUNTRY_CODES.indexOf(code);
        return i === -1 ? 999 : i;
    };
    rows.sort((a, b) => (rank(a.code) - rank(b.code)) || a.name.localeCompare(b.name, 'tr'));
    return rows;
})();

const DIAL_TO_COUNTRY = (() => {
    const m = new Map();
    for (const c of COUNTRY_OPTIONS) if (!m.has(c.dial)) m.set(c.dial, c.code);
    return m;
})();

function dialOf(c) {
    try { return getCountryCallingCode(c); } catch { return ''; }
}

function formatNational(c, raw) {
    const cc = getCountryCallingCode(c);
    const digits = String(raw || '').replace(/\D/g, '');
    const ayt = new AsYouType();
    const intl = ayt.input('+' + cc + digits);
    const display = intl.replace(new RegExp('^\\+' + cc + '\\s*'), '');
    return { display, e164: ayt.getNumber()?.number ?? (digits ? '+' + cc + digits : '') };
}

const SHELL_LIGHT =
    'flex items-center w-full min-h-[42px] rounded-xl border border-gray-200 bg-white transition-colors ' +
    'focus-within:border-brand-500 focus-within:ring-2 focus-within:ring-brand-500/20';
const SHELL_DARK =
    'flex items-center w-full min-h-[40px] rounded-lg border border-white/15 bg-white/[0.06] transition-colors ' +
    'focus-within:border-brand-300 focus-within:ring-4 focus-within:ring-brand-300/15';
const SHELL_INVALID =
    '!border-red-400 focus-within:!border-red-400 focus-within:!ring-red-400/40';

const INPUT_LIGHT =
    'h-full min-w-0 flex-1 border-0 bg-transparent px-2 text-[14px] text-main-900 placeholder:text-gray-400 focus:outline-none focus:ring-0';
const INPUT_DARK =
    'h-full min-w-0 flex-1 border-0 bg-transparent px-2 text-[16px] text-white placeholder:text-white/50 focus:outline-none focus:ring-0';

const BTN_LIGHT =
    'flex shrink-0 items-center gap-1 rounded-l-xl pl-2.5 pr-1.5 py-2.5 text-gray-700 transition hover:bg-gray-50';
const BTN_DARK =
    'flex shrink-0 items-center gap-1 rounded-l-xl pl-2.5 pr-1.5 py-2.5 text-main-100 transition hover:bg-white/5';

const DIVIDER_LIGHT = 'h-6 w-px bg-gray-200';
const DIVIDER_DARK  = 'h-6 w-px bg-white/10';

const MENU_LIGHT = 'overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl';
const MENU_DARK  = 'overflow-hidden rounded-xl border border-white/10 bg-main-900/95 backdrop-blur shadow-2xl';

const SEARCH_LIGHT = 'w-full rounded-lg border border-gray-200 bg-white py-1.5 pl-8 pr-2.5 text-sm text-main-900 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20';
const SEARCH_DARK  = 'w-full rounded-lg border border-white/10 bg-white/5 py-1.5 pl-8 pr-2.5 text-sm text-white placeholder:text-main-300/50 focus:border-brand-400 focus:outline-none focus:ring-2 focus:ring-brand-400/40';

const ITEM_LIGHT   = 'flex w-full items-center gap-2.5 px-3 py-1.5 text-left text-sm transition hover:bg-brand-50 text-main-900';
const ITEM_DARK    = 'flex w-full items-center gap-2.5 px-3 py-1.5 text-left text-sm transition hover:bg-white/5 text-main-100';
const ITEM_ACTIVE_LIGHT = 'bg-brand-50/70';
const ITEM_ACTIVE_DARK  = 'bg-white/10';

let GEO_CACHE = null;
try {
    const saved = localStorage.getItem('lp:geo-country');
    if (saved && /^[A-Z]{2}$/.test(saved)) GEO_CACHE = saved;
} catch {}

async function detectCountry() {
    if (GEO_CACHE) return GEO_CACHE;
    try {
        const r = await fetch('https://ipapi.co/json/', { cache: 'force-cache' });
        const d = await r.json();
        const code = String(d?.country_code || '').toUpperCase();
        if (/^[A-Z]{2}$/.test(code)) {
            GEO_CACHE = code;
            try { localStorage.setItem('lp:geo-country', code); } catch {}
            return code;
        }
    } catch {}
    return null;
}

export function PhoneInput({
    id,
    value,
    onChange,
    onValidChange,
    className,
    disabled,
    defaultCountry = 'TR',
    autoDetectCountry = true,
    placeholder = 'Phone number',
    searchPlaceholder = 'Search country or code',
    countryLabel = 'Country code',
    invalid = false,
    theme = 'light',
}) {
    const [country, setCountry] = useState(defaultCountry);
    const [national, setNational] = useState('');
    const [open, setOpen] = useState(false);
    const [query, setQuery] = useState('');
    const [pos, setPos] = useState(null);
    const lastEmitted = useRef(value ?? '');
    const rootRef = useRef(null);
    const menuRef = useRef(null);
    const searchRef = useRef(null);
    const geoAppliedRef = useRef(false);

    const dark = theme === 'dark';

    useEffect(() => {
        if (value === lastEmitted.current) return;
        lastEmitted.current = value ?? '';
        if (!value) { setNational(''); return; }
        const parsed = parsePhoneNumberFromString(value);
        if (parsed) {
            const c = parsed.country ?? DIAL_TO_COUNTRY.get(parsed.countryCallingCode) ?? country;
            setCountry(c);
            setNational(formatNational(c, parsed.nationalNumber).display);
        } else {
            setNational(value);
        }
    }, [value]);

    // Auto-detect ülke: yalnızca dış value boşsa ve daha önce uygulanmamışsa
    useEffect(() => {
        if (!autoDetectCountry) return;
        if (geoAppliedRef.current) return;
        if (value) return; // dışarıdan gelen değeri ezme
        let cancelled = false;
        detectCountry().then((code) => {
            if (cancelled || !code) return;
            if (geoAppliedRef.current) return;
            geoAppliedRef.current = true;
            if (COUNTRY_OPTIONS.some((c) => c.code === code)) {
                setCountry(code);
            }
        });
        return () => { cancelled = true; };
    }, [autoDetectCountry, value]);

    const emit = (e164) => {
        lastEmitted.current = e164;
        onChange?.(e164);
        if (onValidChange) {
            onValidChange(isRealisticPhone(e164 || ''));
        }
    };

    const apply = (c, raw) => {
        if (String(raw || '').trim().startsWith('+')) {
            const ayt = new AsYouType();
            const intl = ayt.input(raw);
            const num = ayt.getNumber();
            const cc = ayt.getCallingCode();
            const detected = ayt.country ?? (cc ? DIAL_TO_COUNTRY.get(cc) : undefined);
            if (detected) {
                setCountry(detected);
                const dc = getCountryCallingCode(detected);
                setNational(intl.replace(new RegExp('^\\+' + dc + '\\s*'), ''));
            } else {
                setNational(intl);
            }
            emit(num?.number ?? '');
            return;
        }
        const { display, e164 } = formatNational(c, raw);
        setNational(display);
        emit(e164);
    };

    const place = () => {
        const el = rootRef.current;
        if (!el) return;
        const r = el.getBoundingClientRect();
        const width = Math.min(320, window.innerWidth - 16);
        const left = Math.max(8, Math.min(r.left, window.innerWidth - width - 8));
        const gap = 4;
        const spaceBelow = window.innerHeight - r.bottom - 8;
        const spaceAbove = r.top - 8;
        const flip = spaceBelow < 240 && spaceAbove > spaceBelow;
        const maxHeight = Math.max(160, Math.min(288, flip ? spaceAbove : spaceBelow));
        const top = flip ? Math.max(8, r.top - maxHeight - gap) : r.bottom + gap;
        setPos({ top, left, width, maxHeight });
    };

    const openMenu = () => {
        if (disabled) return;
        place();
        setQuery('');
        setOpen(true);
        window.setTimeout(() => searchRef.current?.focus(), 0);
    };

    useEffect(() => {
        if (!open) return;
        const onDoc = (e) => {
            const t = e.target;
            if (!rootRef.current?.contains(t) && !menuRef.current?.contains(t)) setOpen(false);
        };
        const onKey = (e) => { if (e.key === 'Escape') setOpen(false); };
        const onScroll = () => place();
        document.addEventListener('mousedown', onDoc);
        document.addEventListener('keydown', onKey);
        window.addEventListener('scroll', onScroll, true);
        window.addEventListener('resize', onScroll);
        return () => {
            document.removeEventListener('mousedown', onDoc);
            document.removeEventListener('keydown', onKey);
            window.removeEventListener('scroll', onScroll, true);
            window.removeEventListener('resize', onScroll);
        };
    }, [open]);

    const filtered = useMemo(() => {
        const q = query.trim().toLocaleLowerCase('tr');
        if (!q) return COUNTRY_OPTIONS;
        const qDigits = q.replace(/[^0-9]/g, '');
        return COUNTRY_OPTIONS.filter((c) =>
            c.name.toLocaleLowerCase('tr').includes(q)
            || c.code.toLowerCase().includes(q)
            || (qDigits !== '' && c.dial.includes(qDigits)),
        );
    }, [query]);

    const pick = (c) => {
        setCountry(c);
        setOpen(false);
        apply(c, national.replace(/\D/g, ''));
    };

    const shellClass = cn(
        dark ? SHELL_DARK : SHELL_LIGHT,
        invalid && SHELL_INVALID,
        disabled && 'opacity-60 pointer-events-none',
        className,
    );

    return (
        <div ref={rootRef} className={shellClass}>
            <button
                type="button"
                onClick={() => (open ? setOpen(false) : openMenu())}
                disabled={disabled}
                aria-label={countryLabel}
                className={dark ? BTN_DARK : BTN_LIGHT}
            >
                <span className="text-base leading-none">{countryFlag(country)}</span>
                <span className={cn('text-xs tabular-nums', dark ? 'text-main-100/80' : 'text-gray-500')}>
                    +{dialOf(country)}
                </span>
                <svg
                    className={cn('h-1.5 w-2 shrink-0 self-center mt-0.5 transition-transform', open && 'rotate-180', dark ? 'text-main-100/60' : 'text-gray-400')}
                    viewBox="0 0 12 8"
                    fill="none"
                    aria-hidden
                >
                    <path d="M1 1l5 5 5-5" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                </svg>
            </button>
            <span className={dark ? DIVIDER_DARK : DIVIDER_LIGHT} aria-hidden />
            <input
                id={id}
                type="tel"
                inputMode="tel"
                autoComplete="tel-national"
                disabled={disabled}
                value={national}
                onChange={(e) => apply(country, e.target.value)}
                placeholder={placeholder}
                className={cn('py-2.5 leading-none', dark ? INPUT_DARK : INPUT_LIGHT)}
            />

            {open && pos && createPortal(
                <div
                    ref={menuRef}
                    style={{ position: 'fixed', top: pos.top, left: pos.left, width: pos.width, maxHeight: pos.maxHeight, zIndex: 2147483000 }}
                    className={cn(dark ? MENU_DARK : MENU_LIGHT, 'overflow-auto animate-[fadeSlide_.14s_ease-out]')}
                >
                    <div className={cn('sticky top-0 border-b p-2', dark ? 'border-white/10 bg-main-900/95' : 'border-gray-100 bg-white')}>
                        <div className="relative">
                            <svg
                                className={cn('pointer-events-none absolute left-2.5 top-1/2 -translate-y-1/2 h-3.5 w-3.5', dark ? 'text-main-100/50' : 'text-gray-400')}
                                viewBox="0 0 16 16" fill="none" aria-hidden
                            >
                                <circle cx="7" cy="7" r="5" stroke="currentColor" strokeWidth="1.5" />
                                <path d="M15 15l-3-3" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" />
                            </svg>
                            <input
                                ref={searchRef}
                                value={query}
                                onChange={(e) => setQuery(e.target.value)}
                                placeholder={searchPlaceholder}
                                className={dark ? SEARCH_DARK : SEARCH_LIGHT}
                            />
                        </div>
                    </div>
                    {filtered.length === 0 ? (
                        <div className={cn('px-3 py-5 text-center text-xs', dark ? 'text-main-100/50' : 'text-gray-400')}>—</div>
                    ) : (
                        <ul className="py-1">
                            {filtered.map((c) => (
                                <li key={c.code}>
                                    <button
                                        type="button"
                                        onClick={() => pick(c.code)}
                                        className={cn(
                                            dark ? ITEM_DARK : ITEM_LIGHT,
                                            c.code === country && (dark ? ITEM_ACTIVE_DARK : ITEM_ACTIVE_LIGHT),
                                        )}
                                    >
                                        <span className="text-base leading-none">{countryFlag(c.code)}</span>
                                        <span className="flex-1 truncate">{c.name}</span>
                                        <span className={cn('text-xs tabular-nums', dark ? 'text-main-100/60' : 'text-gray-400')}>+{c.dial}</span>
                                    </button>
                                </li>
                            ))}
                        </ul>
                    )}
                </div>,
                document.body,
            )}
        </div>
    );
}
