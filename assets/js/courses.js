// Course related JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Course enrollment functionality
    const enrollButtons = document.querySelectorAll('.enroll-button');
    
    if (enrollButtons.length > 0) {
        enrollButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const courseId = this.dataset.courseId;
                const isLoggedIn = this.dataset.loggedIn === '1';
                
                if (!isLoggedIn) {
                    // Redirect to login page with return URL
                    window.location.href = baseUrl + 'auth/login?redirect=' + encodeURIComponent(window.location.href);
                    return;
                }
                
                // Send AJAX request to enroll
                fetch(baseUrl + 'courses/enroll', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `course_id=${courseId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI to show enrolled status
                        this.textContent = 'Terdaftar';
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-success');
                        this.disabled = true;
                        
                        // Show success message
                        const successMessage = document.createElement('div');
                        successMessage.className = 'alert alert-success mt-3';
                        successMessage.textContent = 'Berhasil mendaftar! Anda sekarang dapat mengakses semua materi kursus.';
                        this.parentNode.appendChild(successMessage);
                        
                        // Redirect to course content after 2 seconds
                        setTimeout(() => {
                            window.location.href = baseUrl + 'courses/' + data.course_slug;
                        }, 2000);
                    } else {
                        // Show error message
                        const errorMessage = document.createElement('div');
                        errorMessage.className = 'alert alert-danger mt-3';
                        errorMessage.textContent = data.message || 'Gagal mendaftar. Silakan coba lagi.';
                        this.parentNode.appendChild(errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error message
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'alert alert-danger mt-3';
                    errorMessage.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
                    this.parentNode.appendChild(errorMessage);
                });
            });
        });
    }
    
    // Course rating functionality
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingForm = document.getElementById('ratingForm');
    const ratingInput = document.getElementById('ratingInput');
    
    if (ratingStars.length > 0 && ratingForm && ratingInput) {
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                ratingInput.value = rating;
                
                // Update UI to show selected rating
                ratingStars.forEach(s => {
                    if (s.dataset.rating <= rating) {
                        s.classList.add('text-warning');
                        s.classList.remove('text-muted');
                    } else {
                        s.classList.remove('text-warning');
                        s.classList.add('text-muted');
                    }
                });
            });
            
            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = this.dataset.rating;
                
                ratingStars.forEach(s => {
                    if (s.dataset.rating <= rating) {
                        s.classList.add('text-warning');
                        s.classList.remove('text-muted');
                    } else {
                        s.classList.remove('text-warning');
                        s.classList.add('text-muted');
                    }
                });
            });
            
            star.addEventListener('mouseleave', function() {
                const currentRating = ratingInput.value;
                
                ratingStars.forEach(s => {
                    if (currentRating && s.dataset.rating <= currentRating) {
                        s.classList.add('text-warning');
                        s.classList.remove('text-muted');
                    } else {
                        s.classList.remove('text-warning');
                        s.classList.add('text-muted');
                    }
                });
            });
        });
    }
    
    // Course completion certificate
    const certificateButton = document.getElementById('generateCertificate');
    
    if (certificateButton) {
        certificateButton.addEventListener('click', function() {
            const courseId = this.dataset.courseId;
            const userId = this.dataset.userId;
            
            // Send AJAX request to generate certificate
            fetch(baseUrl + 'courses/generate_certificate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `course_id=${courseId}&user_id=${userId}`
            })
            .then(response => response.blob())
            .then(blob => {
                // Create a URL for the blob
                const url = window.URL.createObjectURL(blob);
                
                // Create a link to download the certificate
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'certificate.pdf';
                document.body.appendChild(a);
                a.click();
                
                // Clean up
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghasilkan sertifikat. Silakan coba lagi.');
            });
        });
    }
}); 