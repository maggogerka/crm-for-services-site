(() => {
    'use strict';

    document.documentElement.classList.add('has-js');

    const header = document.querySelector('[data-header]');
    const menuButton = document.querySelector('[data-menu-button]');
    const menu = document.querySelector('[data-menu]');

    const updateHeader = () => header?.classList.toggle('is-scrolled', window.scrollY > 12);
    updateHeader();
    window.addEventListener('scroll', updateHeader, { passive: true });

    menuButton?.addEventListener('click', () => {
        const open = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', String(!open));
        menu?.classList.toggle('is-open', !open);
    });

    menu?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
        menuButton?.setAttribute('aria-expanded', 'false');
        menu?.classList.remove('is-open');
    }));

    const gallery = document.querySelector('[data-gallery]');
    const moveGallery = (direction) => {
        if (!gallery) return;
        const card = gallery.querySelector('.gallery-card');
        gallery.scrollBy({ left: direction * ((card?.getBoundingClientRect().width || 340) + 20), behavior: 'smooth' });
    };
    document.querySelector('[data-gallery-prev]')?.addEventListener('click', () => moveGallery(-1));
    document.querySelector('[data-gallery-next]')?.addEventListener('click', () => moveGallery(1));

    document.querySelectorAll('.faq-item').forEach((item) => {
        item.addEventListener('toggle', () => {
            if (!item.open) return;
            document.querySelectorAll('.faq-item[open]').forEach((other) => {
                if (other !== item) other.open = false;
            });
        });
    });

    const revealItems = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -35px' });
        revealItems.forEach((item) => observer.observe(item));
    } else {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    }

    const form = document.querySelector('[data-lead-form]');
    form?.addEventListener('submit', (event) => {
        const required = form.querySelectorAll('[required]');
        let firstInvalid = null;
        required.forEach((field) => {
            field.removeAttribute('aria-invalid');
            if (!field.checkValidity()) {
                field.setAttribute('aria-invalid', 'true');
                firstInvalid ||= field;
            }
        });
        if (firstInvalid) {
            event.preventDefault();
            firstInvalid.focus();
        }
    });
})();
