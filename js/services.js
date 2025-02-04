document.addEventListener('DOMContentLoaded', function() {
    const servicesGrid = document.querySelector('.services-grid');
    const categoryButtons = document.querySelectorAll('.category-btn');
    const serviceCards = document.querySelectorAll('.service-card');

    // Function to filter services
    function filterServices(category) {
        serviceCards.forEach(card => {
            const cardCategory = card.dataset.category;
            
            if (category === 'all' || cardCategory === category) {
                card.style.display = 'block';
                // Add animation
                setTimeout(() => {
                    card.classList.add('visible');
                }, 100);
            } else {
                card.style.display = 'none';
                card.classList.remove('visible');
            }
        });
    }

    // Handle category button clicks
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            // Filter services
            filterServices(this.dataset.category);
        });
    });

    // Initialize with all services visible
    filterServices('all');

    // Add intersection observer for animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    serviceCards.forEach(card => observer.observe(card));
}); 