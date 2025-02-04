document.addEventListener('DOMContentLoaded', function() {
    const blogGrid = document.getElementById('blogPosts');
    const categoryButtons = document.querySelectorAll('.category-btn');
    
    // Function to load blog posts
    function loadBlogPosts(category = 'all') {
        // Show loading spinner
        blogGrid.innerHTML = '<div class="loading-spinner">Loading...</div>';
        
        fetch('blog.php' + (category !== 'all' ? '?category=' + category : ''))
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(html => {
                blogGrid.innerHTML = html;
                // Add fade-in animation to loaded posts
                const posts = blogGrid.querySelectorAll('.blog-post');
                posts.forEach(post => {
                    post.classList.add('fade-in');
                    setTimeout(() => {
                        post.classList.add('visible');
                    }, 100);
                });
            })
            .catch(error => {
                console.error('Error loading blog posts:', error);
                blogGrid.innerHTML = '<div class="error-message">Error loading blog posts. Please try again later.</div>';
            });
    }

    // Handle category filtering
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            // Load posts for selected category
            loadBlogPosts(this.dataset.category);
        });
    });

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

    // Initial load of blog posts
    loadBlogPosts();
}); 