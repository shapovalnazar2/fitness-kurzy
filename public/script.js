const elements = document.querySelectorAll('.fade-up');

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');

            // Po animácii prestaneme sledovať element
            observer.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.15
});

elements.forEach(element => observer.observe(element));