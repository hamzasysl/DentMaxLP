import { parsePhoneNumberFromString } from 'libphonenumber-js';

// libphonenumber "valid" dese bile bariz sahte/test kalıplarını reddet.
// Örn: +90 551 555 55 55 → national 5515555555 (7 tane arka arkaya 5).
export function isRealisticPhone(e164) {
    if (!e164 || typeof e164 !== 'string') return false;
    let parsed;
    try { parsed = parsePhoneNumberFromString(e164); } catch { return false; }
    if (!parsed || !parsed.isValid()) return false;

    const nat = String(parsed.nationalNumber || '');
    if (nat.length < 6) return false;

    // 6 veya daha fazla arka arkaya aynı rakam → test numarası
    if (/(\d)\1{5,}/.test(nat)) return false;

    // Ulusal numarada 3'ten fazla farklı rakam yoksa (örn 1212121212) reddet
    const unique = new Set(nat.split('')).size;
    if (unique <= 2) return false;

    // Bariz artan/azalan diziler (1234567890, 0987654321)
    if (/^(?:0123456789|1234567890|9876543210|0987654321)$/.test(nat)) return false;

    return true;
}
