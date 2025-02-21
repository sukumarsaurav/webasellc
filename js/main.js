// Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    
    dropdownTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            // Add dropdown functionality here
        });
    });

    // Mobile menu toggle
   
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
// Add this to your existing JavaScript

// Handle mobile menu dropdown toggles
document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth <= 768) {
        const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
        
        dropdownTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const megaMenu = this.closest('.has-dropdown').querySelector('.mega-menu');
                megaMenu.style.display = megaMenu.style.display === 'block' ? 'none' : 'block';
            });
        });
    }
    
    // Close mega menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.has-dropdown')) {
            const megaMenus = document.querySelectorAll('.mega-menu');
            megaMenus.forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
});

// Update mega menu position on window resize
window.addEventListener('resize', function() {
    const megaMenus = document.querySelectorAll('.mega-menu');
    if (window.innerWidth > 768) {
        megaMenus.forEach(menu => {
            menu.style.display = '';
        });
    }
});
document.addEventListener('DOMContentLoaded', function() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            const link = this.querySelector('h3').textContent.toLowerCase().replace(/[^a-z0-9]/g, '-');
            window.location.href = `/products/${link}`;
        });
    });
});
// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');
            
            // Close all FAQ items
            faqItems.forEach(faqItem => {
                faqItem.classList.remove('active');
            });
            
            // If the clicked item wasn't active, open it
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
});

// Add this to your existing JavaScript
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const sidebarClose = document.querySelector('.sidebar-close');
    const overlay = document.querySelector('.overlay');

    // Open sidebar
    menuToggle.addEventListener('click', function() {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when sidebar is open
    });

    // Close sidebar
    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }

    sidebarClose.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Close sidebar on window resize if screen becomes larger than 768px
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
});

// Add this to your existing main.js
document.addEventListener('DOMContentLoaded', function() {
    // Check if browser supports native lazy loading
    if ('loading' in HTMLImageElement.prototype) {
        // Browser supports native lazy loading
        const images = document.querySelectorAll('img[loading="lazy"]');
        images.forEach(img => {
            img.src = img.dataset.src;
        });
    } else {
        // Fallback for browsers that don't support native lazy loading
        const script = document.createElement('script');
        script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lozad.js/1.16.0/lozad.min.js';
        script.async = true;
        script.onload = function() {
            const observer = lozad();
            observer.observe();
        };
        document.body.appendChild(script);
    }
});

// Defer non-critical scripts
function loadScript(src) {
    return new Promise((resolve, reject) => {
        const script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.onload = resolve;
        script.onerror = reject;
        document.body.appendChild(script);
    });
}

// Load scripts after page load
window.addEventListener('load', async () => {
    try {
        // Load FontAwesome only if needed
        if (document.querySelector('.fas, .fab')) {
            await loadScript('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js');
        }
        
        // Load other non-critical scripts
        if (document.querySelector('[data-aos]')) {
            await loadScript('https://unpkg.com/aos@next/dist/aos.js');
            AOS.init();
        }
    } catch (error) {
        console.error('Error loading scripts:', error);
    }
});

// Add backlink monitoring functionality
async function checkBacklinks() {
    try {
        const response = await fetch('/api/check-backlinks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                domain: window.location.hostname
            })
        });
        
        if (response.ok) {
            const data = await response.json();
            // Send backlink data to Google Analytics
            gtag('event', 'backlink_check', {
                'event_category': 'SEO',
                'event_label': 'Backlink Count',
                'value': data.totalBacklinks
            });
        }
    } catch (error) {
        console.error('Error checking backlinks:', error);
    }
}

// Check backlinks periodically
if (typeof gtag !== 'undefined') {
    // Initial check
    checkBacklinks();
    // Check every 24 hours
    setInterval(checkBacklinks, 24 * 60 * 60 * 1000);
}

// Track outbound links
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="http"]').forEach(link => {
        link.addEventListener('click', function(e) {
            const url = this.getAttribute('href');
            if (!url.includes(window.location.hostname)) {
                gtag('event', 'outbound_link', {
                    'event_category': 'engagement',
                    'event_label': url
                });
            }
        });
    });
});

// Add to existing main.js
document.addEventListener('DOMContentLoaded', function() {
    // Load SEO monitoring scripts
    loadScript('/js/seo-monitor.js');
    loadScript('/js/analytics-dashboard.js');
    
    // Initialize A/B testing if Google Optimize is present
    if (typeof google_optimize !== 'undefined') {
        google_optimize.get('YOUR_EXPERIMENT_ID', function(value) {
            // Handle different variants
            switch(value) {
                case '0': // Original
                    break;
                case '1': // Variant 1
                    applyVariant1Styles();
                    break;
                case '2': // Variant 2
                    applyVariant2Styles();
                    break;
            }
        });
    }
});

// Track SEO metrics
function trackSEOMetrics() {
    // Track page load time
    const pageLoadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
    gtag('event', 'page_performance', {
        'event_category': 'Performance',
        'event_label': 'Page Load Time',
        'value': pageLoadTime
    });
    
    // Track scroll depth
    let maxScroll = 0;
    window.addEventListener('scroll', () => {
        const scrollPercent = (window.scrollY + window.innerHeight) / document.documentElement.scrollHeight * 100;
        maxScroll = Math.max(maxScroll, Math.round(scrollPercent));
    });
    
    // Send scroll depth on page unload
    window.addEventListener('beforeunload', () => {
        gtag('event', 'scroll_depth', {
            'event_category': 'Engagement',
            'event_label': 'Max Scroll',
            'value': maxScroll
        });
    });
}

// Initialize tracking
trackSEOMetrics();