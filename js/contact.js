document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const formMessage = document.getElementById('formMessage');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Clear previous messages
            formMessage.textContent = '';
            formMessage.className = 'form-message';

            // Collect form data
            const formData = new FormData(contactForm);

            // Send form data using fetch
            fetch('contact-us.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Display response message
                formMessage.textContent = data.message;
                formMessage.classList.add(data.status);

                // If submission was successful, reset the form
                if (data.status === 'success') {
                    contactForm.reset();
                }
            })
            .catch(error => {
                formMessage.textContent = 'An error occurred. Please try again later.';
                formMessage.classList.add('error');
                console.error('Error:', error);
            });
        });
    }

    // Optional: Add phone number formatting
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    }
}); 