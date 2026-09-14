import Alpine from 'alpinejs';

Alpine.store('theme', {
    value: localStorage.getItem('theme') || 'dark',

    init() {
        this.apply();
    },

    toggle() {
        this.value = this.value === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', this.value);
        this.apply();
    },

    apply() {
        document.documentElement.classList.toggle('dark', this.value === 'dark');
    },
});

window.Alpine = Alpine;
Alpine.start();

const revealObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.12, rootMargin: '0px 0px -60px 0px' }
);

function observeReveals() {
    document.querySelectorAll('.reveal:not(.reveal-visible)').forEach((el) => revealObserver.observe(el));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', observeReveals);
} else {
    observeReveals();
}

const skillBarObserver = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const bar = entry.target;
                bar.style.width = `${bar.dataset.width}%`;
                skillBarObserver.unobserve(bar);
            }
        });
    },
    { threshold: 0.3 }
);

function observeSkillBars() {
    document.querySelectorAll('.skill-fill[data-width]').forEach((bar) => skillBarObserver.observe(bar));
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', observeSkillBars);
} else {
    observeSkillBars();
}
