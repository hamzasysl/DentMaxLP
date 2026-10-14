import { createRoot } from 'react-dom/client';
import { useEffect, useState } from 'react';
import { PhoneInput } from './PhoneInput.jsx';
import { isRealisticPhone } from './phoneHeuristics.js';

const MOUNTED = new WeakMap();
const REGISTRY = new Set();

function readAttrs(el) {
    return {
        inputId: el.dataset.inputId || '',
        hiddenTarget: el.dataset.hiddenTarget || '',
        defaultCountry: (el.dataset.defaultCountry || 'TR').toUpperCase(),
        placeholder: el.dataset.placeholder || '',
        searchPlaceholder: el.dataset.searchPlaceholder || '',
        countryLabel: el.dataset.countryLabel || 'Country code',
        invalidText: el.dataset.invalidText || 'Please enter a valid phone number.',
        theme: el.dataset.theme === 'dark' ? 'dark' : 'light',
        autoDetect: el.dataset.autoDetectCountry !== 'false',
        shellClass: el.dataset.shellClass || '',
    };
}

function findHidden(target) {
    return target ? document.getElementById(target) : null;
}

function writeHidden(hidden, value) {
    if (!hidden) return;
    if (hidden.value === value) return;
    hidden.value = value;
    hidden.dispatchEvent(new Event('input', { bubbles: true }));
    hidden.dispatchEvent(new Event('change', { bubbles: true }));
}

function showError(host, text) {
    if (!host) return;
    let msg = host.parentElement?.querySelector(':scope > .react-phone-error');
    if (!msg) {
        msg = document.createElement('p');
        msg.className = 'react-phone-error mt-1 text-[12px] text-red-500';
        host.insertAdjacentElement('afterend', msg);
    }
    msg.textContent = text;
}

function clearError(host) {
    const msg = host?.parentElement?.querySelector(':scope > .react-phone-error');
    if (msg) msg.remove();
}

function PhoneShell({ host, attrs }) {
    const hidden = findHidden(attrs.hiddenTarget);
    const initial = hidden?.value || '';
    const [value, setValue] = useState(initial);
    const [invalid, setInvalid] = useState(false);
    const [touched, setTouched] = useState(false);

    // Hidden input dış değişiklikleri (Livewire reset vb.) yakala
    useEffect(() => {
        if (!hidden) return;
        const onExt = () => {
            if (hidden.value !== value) setValue(hidden.value || '');
        };
        hidden.addEventListener('input', onExt);
        hidden.addEventListener('change', onExt);
        return () => {
            hidden.removeEventListener('input', onExt);
            hidden.removeEventListener('change', onExt);
        };
    }, [hidden, value]);

    // Registry: submit gate global check için
    useEffect(() => {
        const entry = {
            host,
            isValid: () => {
                if (!hidden?.value) return true; // required kontrolü server'da
                return isRealisticPhone(hidden.value);
            },
            markInvalid: () => {
                setTouched(true);
                setInvalid(true);
                showError(host, attrs.invalidText);
            },
        };
        REGISTRY.add(entry);
        return () => REGISTRY.delete(entry);
    }, [host, hidden, attrs.invalidText]);

    return (
        <PhoneInput
            id={attrs.inputId}
            value={value}
            onChange={(e164) => {
                setValue(e164);
                writeHidden(hidden, e164);
                if (invalid) { setInvalid(false); clearError(host); }
            }}
            onValidChange={(ok) => {
                if (!touched) return;
                if (ok) { setInvalid(false); clearError(host); }
            }}
            defaultCountry={attrs.defaultCountry}
            autoDetectCountry={attrs.autoDetect}
            placeholder={attrs.placeholder}
            searchPlaceholder={attrs.searchPlaceholder}
            countryLabel={attrs.countryLabel}
            invalid={invalid}
            theme={attrs.theme}
            className={attrs.shellClass}
        />
    );
}

function mountOne(el) {
    if (MOUNTED.has(el)) return;
    const attrs = readAttrs(el);
    const root = createRoot(el);
    root.render(<PhoneShell host={el} attrs={attrs} />);
    MOUNTED.set(el, root);
}

function unmountDetached() {
    // WeakMap: DOM'dan düşen elementleri manuel unmount edemeyiz;
    // React onları GC ile toplar. WeakMap yaşam süresi element ile eşit.
}

function scan() {
    document.querySelectorAll('[data-react-phone]').forEach(mountOne);
}

// Global submit gate: geçersiz numarayla submit'i engelle
function anyInvalid(scope) {
    let bad = null;
    REGISTRY.forEach((entry) => {
        if (bad) return;
        if (scope && !scope.contains(entry.host)) return;
        if (!entry.isValid()) bad = entry;
    });
    return bad;
}

function installSubmitGate() {
    // <form wire:submit> için
    document.addEventListener('submit', (e) => {
        const form = e.target;
        if (!(form instanceof HTMLElement)) return;
        const bad = anyInvalid(form);
        if (bad) {
            e.preventDefault();
            e.stopImmediatePropagation();
            bad.markInvalid();
            bad.host?.querySelector('input[type="tel"]')?.focus();
        }
    }, true);

    // wire:click ile submit tetikleyen butonlar için (step-form / lucky-spin)
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[wire\\:click], button[type="submit"]');
        if (!btn) return;
        const wireAttr = btn.getAttribute('wire:click') || '';
        const looksLikeSubmit = /submit|spin|save|send|next/i.test(wireAttr) || btn.type === 'submit';
        if (!looksLikeSubmit) return;

        const scope = btn.closest('form') || btn.closest('[wire\\:id]') || document.body;
        const bad = anyInvalid(scope);
        if (bad) {
            e.preventDefault();
            e.stopImmediatePropagation();
            bad.markInvalid();
            bad.host?.querySelector('input[type="tel"]')?.focus();
        }
    }, true);
}

function boot() {
    scan();
    installSubmitGate();
    installObserver();
}

// DOM'a sonradan eklenen slotları (modal/step/tab) yakala.
function installObserver() {
    if (typeof MutationObserver === 'undefined') return;
    const obs = new MutationObserver((records) => {
        for (const r of records) {
            for (const node of r.addedNodes) {
                if (node.nodeType !== 1) continue;
                if (node.matches?.('[data-react-phone]')) mountOne(node);
                node.querySelectorAll?.('[data-react-phone]').forEach(mountOne);
            }
        }
    });
    obs.observe(document.body, { childList: true, subtree: true });
}

document.addEventListener('DOMContentLoaded', boot);
document.addEventListener('livewire:navigated', scan);
document.addEventListener('livewire:init', () => {
    scan();
    window.Livewire?.hook?.('morph.updated', () => scan());
});
window.addEventListener('pageshow', scan);
