// Authentication related JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Form validation for registration
    const registrationForm = document.getElementById('registrationForm');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const passwordError = document.getElementById('passwordError');
            
            if (password !== confirmPassword) {
                e.preventDefault();
                passwordError.textContent = 'Password tidak cocok!';
                passwordError.style.display = 'block';
                return false;
            }
            
            // Password strength validation
            if (password.length < 8) {
                e.preventDefault();
                passwordError.textContent = 'Password harus minimal 8 karakter!';
                passwordError.style.display = 'block';
                return false;
            }
            
            // Check for at least one number and one special character
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            
            if (!hasNumber || !hasSpecial) {
                e.preventDefault();
                passwordError.textContent = 'Password harus mengandung minimal 1 angka dan 1 karakter khusus!';
                passwordError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Login form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const loginError = document.getElementById('loginError');
            
            if (!email || !password) {
                e.preventDefault();
                loginError.textContent = 'Email dan password harus diisi!';
                loginError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Password reset functionality
    const resetForm = document.getElementById('resetPasswordForm');
    if (resetForm) {
        resetForm.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const resetError = document.getElementById('resetError');
            
            if (!email) {
                e.preventDefault();
                resetError.textContent = 'Silakan masukkan email Anda!';
                resetError.style.display = 'block';
                return false;
            }
            
            // Email format validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                resetError.textContent = 'Format email tidak valid!';
                resetError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Show/hide password toggle
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');
    
    if (togglePassword && passwordField) {
        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    }
}); 