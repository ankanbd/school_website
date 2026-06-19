// School Website Custom JavaScript

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
    setupEventListeners();
    handleResponsiveFeatures();
});

// Defer loading YouTube embeds until full page load
window.addEventListener('load', function() {
    const lazyYouTubeIframes = document.querySelectorAll('iframe[data-youtube-src]');
    lazyYouTubeIframes.forEach((iframe) => {
        const src = iframe.getAttribute('data-youtube-src');
        if (src) {
            iframe.setAttribute('src', src);
            iframe.removeAttribute('data-youtube-src');
            iframe.setAttribute('loading', 'lazy');
            iframe.setAttribute('decoding', 'async');
        }
    });
});

// Initialize all components
function initializeComponents() {
    initializeBackToTop();
    initializeNavbarScroll();
    initializeImageLazyLoad();
    initializeFormValidation();
}

// Back to top button functionality
function initializeBackToTop() {
    const backToTopButton = document.createElement('button');
    backToTopButton.innerHTML = '↑';
    backToTopButton.className = 'btn btn-primary back-to-top';
    backToTopButton.style.cssText = 'position: fixed; bottom: 20px; right: 20px; display: none; z-index: 9999; border-radius: 50%; width: 50px; height: 50px;';
    document.body.appendChild(backToTopButton);

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTopButton.style.display = 'block';
        } else {
            backToTopButton.style.display = 'none';
        }
    });

    backToTopButton.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Navbar scroll effect
function initializeNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
    }
}

// Image lazy loading
function initializeImageLazyLoad() {
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// Form validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showAlert('Please fill in all required fields.', 'danger');
            }
        });
    });
}

// Setup event listeners
function setupEventListeners() {
    // Rely on Bootstrap's built-in collapse; remove manual toggling to avoid conflicts

    // Smooth scrolling for anchor links (exclude dropdown toggles and empty hashes)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            const isEmptyHash = href === '#' || href === '#!' || href === '#0';
            const isDropdownToggle = this.classList.contains('dropdown-toggle') || this.getAttribute('data-bs-toggle') === 'dropdown';

            if (isDropdownToggle || isEmptyHash) {
                // Prevent adding a trailing hash to the URL
                if (isEmptyHash || isDropdownToggle) {
                    e.preventDefault();
                }
                return; // let Bootstrap handle dropdowns or ignore empty hash
            }

            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Auto-collapse navbar on link click (mobile only)
    const navbarCollapseEl = document.getElementById('mainNavbar');
    if (navbarCollapseEl) {
        navbarCollapseEl.addEventListener('click', function(e) {
            const clickedLink = e.target.closest('a.nav-link, .dropdown-item');
            const isDropdownToggle = clickedLink && clickedLink.classList.contains('dropdown-toggle');
            if (!clickedLink || isDropdownToggle) return;

            const toggler = document.querySelector('.navbar-toggler');
            const isMobile = toggler && window.getComputedStyle(toggler).display !== 'none';
            if (!isMobile) return;

            if (window.bootstrap && bootstrap.Collapse) {
                const instance = bootstrap.Collapse.getOrCreateInstance(navbarCollapseEl, { toggle: false });
                instance.hide();
            }
        });
    }

    // Image gallery lightbox
    const galleryImages = document.querySelectorAll('.gallery-image');
    galleryImages.forEach(img => {
        img.addEventListener('click', function() {
            openLightbox(this.src, this.alt);
        });
    });
}

// Handle responsive features
function handleResponsiveFeatures() {
    // Responsive table wrapper
    const tables = document.querySelectorAll('table');
    tables.forEach(table => {
        if (!table.parentElement.classList.contains('table-responsive')) {
            const wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
}

// Utility functions
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container') || document.body;
    container.insertBefore(alertDiv, container.firstChild);

    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
}

// Lightbox functionality
function openLightbox(src, alt) {
    const lightbox = document.createElement('div');
    lightbox.className = 'lightbox';
    lightbox.innerHTML = `
        <div class="lightbox-content">
            <span class="lightbox-close">&times;</span>
            <img src="${src}" alt="${alt}" class="lightbox-image">
        </div>
    `;

    lightbox.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
    `;

    lightbox.querySelector('.lightbox-close').style.cssText = `
        position: absolute;
        top: 20px;
        right: 40px;
        color: white;
        font-size: 40px;
        cursor: pointer;
    `;

    lightbox.querySelector('.lightbox-image').style.cssText = `
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    `;

    document.body.appendChild(lightbox);

    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox || e.target.classList.contains('lightbox-close')) {
            document.body.removeChild(lightbox);
        }
    });
}

// Dynamic year in footer
function updateFooterYear() {
    const yearElements = document.querySelectorAll('.current-year');
    const currentYear = new Date().getFullYear();
    yearElements.forEach(element => {
        element.textContent = currentYear;
    });
}

// Initialize footer year
updateFooterYear();

// Form submission handling
function handleFormSubmission(form) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
    }
}

// Add loading state to buttons
document.addEventListener('click', function(e) {
    if (e.target.matches('button[type="submit"]')) {
        const form = e.target.closest('form');
        if (form) {
            handleFormSubmission(form);
        }
    }
});

// Smooth reveal animations
function revealOnScroll() {
    const reveals = document.querySelectorAll('.reveal');
    reveals.forEach(element => {
        const windowHeight = window.innerHeight;
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;

        if (elementTop < windowHeight - elementVisible) {
            element.classList.add('active');
        }
    });
}

window.addEventListener('scroll', revealOnScroll);
revealOnScroll(); // Initial check

// Print functionality
function printPage() {
    window.print();
}

// Share functionality
function sharePage() {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            showAlert('Link copied to clipboard!', 'success');
        });
    }
}

// Dark mode toggle (if needed)
function initializeDarkMode() {
    const darkModeToggle = document.querySelector('#dark-mode-toggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
        });

        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            document.body.classList.add('dark-mode');
        }
    }
}

// Initialize dark mode
initializeDarkMode();