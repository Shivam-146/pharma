document.addEventListener('DOMContentLoaded', () => {
    // 0. Preloader Logic
    const preloader = document.getElementById('preloader');
    if (preloader) {
        let preloaderHidden = false;
        const hidePreloader = () => {
            if (preloaderHidden) return;
            preloaderHidden = true;
            preloader.style.opacity = '0';
            preloader.style.visibility = 'hidden';
            document.body.classList.add('fade-in');
        };

        // Hide when the window is fully loaded
        window.addEventListener('load', hidePreloader);

        // Fallback: hide after 800ms if assets (like the background video) take too long
        setTimeout(hidePreloader, 800);
    }

    // 1. Load Header
    fetch('components/header.html?v=1.0.1')
        .then(response => response.text())
        .then(data => {
            const headerPlaceholder = document.getElementById('header-placeholder');
            if (headerPlaceholder) {
                headerPlaceholder.innerHTML = data;
                initNavbar();
            }
        });

    // 2. Load Footer
    fetch('components/footer.html?v=1.0.1')
        .then(response => response.text())
        .then(data => {
            const footerPlaceholder = document.getElementById('footer-placeholder');
            if (footerPlaceholder) {
                footerPlaceholder.innerHTML = data;
                initHoverLetters();
            }
        });

    // 3. Scroll Reveal Logic
    const reveals = document.querySelectorAll('.reveal');
    const revealOnScroll = () => {
        const windowHeight = window.innerHeight;
        const elementVisible = 100;
        reveals.forEach(reveal => {
            const elementTop = reveal.getBoundingClientRect().top;
            if (elementTop < windowHeight - elementVisible) {
                reveal.classList.add('active');
            }
        });
    };
    window.addEventListener('scroll', revealOnScroll);
    revealOnScroll(); // Trigger on initial load
});

function initNavbar() {
    const navbar = document.getElementById('navbar');
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const navLogoText = document.getElementById('nav-logo-text');
    const navLinks = document.querySelectorAll('.nav-link');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    const isHomePage = window.location.pathname.endsWith('index.html') || window.location.pathname.endsWith('/') || !window.location.pathname.includes('.');

    // Initial Active Link Highlight
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    
    const highlightLinks = (links) => {
        links.forEach(link => {
            link.classList.remove('nav-link-active', 'text-blue-600', 'font-bold');
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === 'product.php' && href === 'products.php')) {
                link.classList.add('nav-link-active');
            }
        });
    };

    highlightLinks(navLinks);
    highlightLinks(mobileNavLinks);

    // Mobile Menu Toggle
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Scroll Effect (applies to all pages)
    const handleScroll = () => {
        if (navbar) {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white', 'shadow-xl', 'py-3');
                navbar.classList.remove('bg-transparent', 'py-4', 'text-white');
                if (navLogoText) navLogoText.classList.add('text-slate-900');
                if (navLogoText) navLogoText.classList.remove('text-white');
                if (mobileMenuBtn) mobileMenuBtn.classList.add('text-slate-900');
                if (mobileMenuBtn) mobileMenuBtn.classList.remove('text-white');
                
                navLinks.forEach(link => {
                    if (!link.classList.contains('nav-link-active')) {
                        link.classList.add('text-slate-600');
                        link.classList.remove('text-white');
                    }
                });
            } else {
                navbar.classList.remove('bg-white', 'shadow-xl', 'py-3');
                navbar.classList.add('bg-transparent', 'py-4', 'text-white');
                if (navLogoText) navLogoText.classList.remove('text-slate-900');
                if (navLogoText) navLogoText.classList.add('text-white');
                if (mobileMenuBtn) mobileMenuBtn.classList.remove('text-slate-900');
                if (mobileMenuBtn) mobileMenuBtn.classList.add('text-white');

                navLinks.forEach(link => {
                    if (!link.classList.contains('nav-link-active')) {
                        link.classList.add('text-white');
                        link.classList.remove('text-slate-600');
                    }
                });
            }
        }
    };

    // Initial check and scroll event listener for all pages
    handleScroll();
    window.addEventListener('scroll', handleScroll);
}

// Sheryians-style letter hover effect
function initHoverLetters() {
    const letters = Array.from(document.querySelectorAll('.hover-letter'));
    if (!letters.length) return;

    const clearAll = () => {
        letters.forEach(l => l.classList.remove('is-active', 'is-near', 'is-far'));
    };

    letters.forEach((letter, idx) => {
        letter.addEventListener('mouseenter', () => {
            clearAll();

            // Hovered letter: fully filled
            letter.classList.add('is-active');

            // Immediate neighbors (±1): half-filled bleed
            if (letters[idx - 1]) letters[idx - 1].classList.add('is-near');
            if (letters[idx + 1]) letters[idx + 1].classList.add('is-near');

            // Second-degree neighbors (±2): faint glow
            if (letters[idx - 2]) letters[idx - 2].classList.add('is-far');
            if (letters[idx + 2]) letters[idx + 2].classList.add('is-far');
        });

        letter.addEventListener('mouseleave', (e) => {
            // Only clear if not moving to another hover-letter
            if (!e.relatedTarget || !e.relatedTarget.classList.contains('hover-letter')) {
                clearAll();
            }
        });
    });
}
