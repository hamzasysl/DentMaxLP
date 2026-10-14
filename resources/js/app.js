import './bootstrap';
import './react/mount.jsx';

// ===== Premium efektler: kaydırınca belirme + mouse ışığı =====
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-in');
        revealObserver.unobserve(entry.target);
    });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

const bootReveal = () => {
    document.querySelectorAll('[data-reveal]:not(.is-in), .line-grow:not(.is-in)').forEach((el) => revealObserver.observe(el));
};
document.addEventListener('DOMContentLoaded', bootReveal);
document.addEventListener('livewire:navigated', bootReveal);
document.addEventListener('livewire:initialized', bootReveal);

document.addEventListener('pointermove', (e) => {
    const card = e.target.closest?.('.spotlight');
    if (!card) return;
    const r = card.getBoundingClientRect();
    card.style.setProperty('--x', `${e.clientX - r.left}px`);
    card.style.setProperty('--y', `${e.clientY - r.top}px`);
});

// KVKK aydınlatma metni: href="#kvkk" olan her link site içi pencereyi açar
document.addEventListener('click', (e) => {
    const link = e.target.closest('a[href="#kvkk"]');
    if (!link) return;
    e.preventDefault();
    window.dispatchEvent(new CustomEvent('open-kvkk'));
});

// Footer'ın en alt satırı görünürken köşedeki WhatsApp / kampanya butonlarını gizle
function bootFabHide() {
    const target = document.getElementById('footer-bottom');
    if (!target || !('IntersectionObserver' in window) || target.dataset.fabObserved) return;
    target.dataset.fabObserved = '1';
    new IntersectionObserver(([entry]) => {
        document.documentElement.classList.toggle('fab-hidden', entry.isIntersecting);
    }, { rootMargin: '0px 0px 40px 0px' }).observe(target);
}
document.addEventListener('DOMContentLoaded', bootFabHide);
document.addEventListener('livewire:navigated', bootFabHide);
