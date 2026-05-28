(() => {
    document.documentElement.classList.add('motion-ready');
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        document.documentElement.classList.remove('motion-ready');
        document.querySelectorAll('[data-reveal]').forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const revealItems = Array.from(document.querySelectorAll('[data-reveal]'));
    revealItems.forEach((el, index) => {
        const localIndex = Array.from(el.parentElement?.querySelectorAll?.('[data-reveal]') || []).indexOf(el);
        const delay = Math.max(0, localIndex) * 120;
        el.style.setProperty('--reveal-delay', `${Math.min(delay, 520)}ms`);
    });

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            } else {
                entry.target.classList.remove('is-visible');
            }
        });
    }, {
        threshold: 0.18,
        rootMargin: '-8% 0px -10% 0px',
    });

    revealItems.forEach((el) => revealObserver.observe(el));

    const parallaxItems = Array.from(document.querySelectorAll('[data-parallax]'));
    let ticking = false;

    const updateParallax = () => {
        const viewportHeight = window.innerHeight || 1;
        parallaxItems.forEach((el) => {
            const speed = parseFloat(el.dataset.parallax || '0.05');
            const rect = el.getBoundingClientRect();
            const progress = (rect.top + rect.height / 2 - viewportHeight / 2) / viewportHeight;
            const y = progress * viewportHeight * speed;
            el.style.transform = `translate3d(0, ${y.toFixed(2)}px, 0)`;
        });
        ticking = false;
    };

    const requestParallax = () => {
        if (!ticking) {
            window.requestAnimationFrame(updateParallax);
            ticking = true;
        }
    };

    window.addEventListener('scroll', requestParallax, { passive: true });
    window.addEventListener('resize', requestParallax);
    updateParallax();

    document.querySelectorAll('[data-tilt]').forEach((card) => {
        let frame = null;
        const maxTilt = 5;

        const move = (event) => {
            if (frame) cancelAnimationFrame(frame);
            frame = requestAnimationFrame(() => {
                const rect = card.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * -maxTilt;
                const rotateY = ((x - centerX) / centerX) * maxTilt;
                card.style.transform = `perspective(1100px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-4px)`;
            });
        };

        const leave = () => {
            if (frame) cancelAnimationFrame(frame);
            card.style.transform = '';
        };

        card.addEventListener('mousemove', move);
        card.addEventListener('mouseleave', leave);
    });
})();
