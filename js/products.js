document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded');
    const productsContainer = document.getElementById('productsContainer');
    console.log('Products Container:', productsContainer);
    const categoryButtons = document.querySelectorAll('.category-btn');
    console.log('Category Buttons:', categoryButtons);
    
    // Product data (you can move this to a separate JSON file or database)
    const products = [
        {
            id: 1,
            name: 'E-commerce Platform',
            category: 'ecommerce',
            description: 'Complete e-commerce solution for your business',
            image: 'src/images/ai.png',
            features: ['Multi-vendor support', 'Payment gateway integration', 'Inventory management']
        },
        {
            id: 2,
            name: 'Enterprise CRM',
            category: 'enterprise',
            description: 'Advanced CRM system for large organizations',
            image: 'src/images/ai.png',
            features: ['Customer tracking', 'Sales analytics', 'Team collaboration']
        },
        {
            id: 3,
            name: 'Project Management Suite',
            category: 'management',
            description: 'Comprehensive project management solution',
            image: 'src/images/ai.png',
            features: ['Task tracking', 'Team collaboration', 'Resource management']
        },
        {
            id: 4,
            name: 'Online Store Builder',
            category: 'ecommerce',
            description: 'Build your online store in minutes',
            image: 'src/images/ai.png',
            features: ['Drag-and-drop builder', 'Mobile responsive', 'SEO optimized']
        },
        {
            id: 5,
            name: 'Enterprise Analytics',
            category: 'enterprise',
            description: 'Advanced analytics for enterprise businesses',
            image: 'src/images/ai.png',
            features: ['Real-time reporting', 'Custom dashboards', 'Data visualization']
        }
    ];

    function displayProducts(category = 'all') {
        console.log('Displaying products for category:', category);
        console.log('Products container:', productsContainer);
        
        if (!productsContainer) {
            console.error('Products container not found!');
            return;
        }

        productsContainer.innerHTML = '';
        
        const filteredProducts = category === 'all' 
            ? products 
            : products.filter(product => product.category === category);
        
        console.log('Filtered products:', filteredProducts);

        if (filteredProducts.length === 0) {
            console.log('No products found for category:', category);
            productsContainer.innerHTML = '<p class="no-products">No products found in this category.</p>';
            return;
        }

        filteredProducts.forEach(product => {
            console.log('Creating element for product:', product.name);
            const productElement = document.createElement('div');
            productElement.className = 'product-card fade-in';
            productElement.innerHTML = `
                <div class="product-image">
                    <img src="${product.image}" alt="${product.name}" onerror="this.src='src/images/placeholder.jpg'">
                </div>
                <div class="product-content">
                    <h3>${product.name}</h3>
                    <p>${product.description}</p>
                    <ul class="features-list">
                        ${product.features.map(feature => `<li>${feature}</li>`).join('')}
                    </ul>
                    <a href="/products/${product.id}" class="learn-more">Learn More</a>
                </div>
            `;
            productsContainer.appendChild(productElement);
        });

        // Add animation
        setTimeout(() => {
            document.querySelectorAll('.product-card').forEach(card => {
                card.classList.add('visible');
            });
        }, 100);
    }

    // Handle category filtering
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            // Display products for selected category
            displayProducts(this.dataset.category);
        });
    });

    // Initial display
    displayProducts();
}); 