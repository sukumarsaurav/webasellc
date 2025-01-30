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