// Profile related JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Profile image upload preview
    const profileImageInput = document.getElementById('profileImage');
    const profileImagePreview = document.getElementById('profileImagePreview');
    
    if (profileImageInput && profileImagePreview) {
        profileImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    profileImagePreview.src = e.target.result;
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Profile form validation
    const profileForm = document.getElementById('profileForm');
    
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            const fullName = document.getElementById('fullName').value;
            const bio = document.getElementById('bio').value;
            const profileError = document.getElementById('profileError');
            
            if (!fullName) {
                e.preventDefault();
                profileError.textContent = 'Nama lengkap harus diisi!';
                profileError.style.display = 'block';
                return false;
            }
            
            // Bio length validation
            if (bio && bio.length > 500) {
                e.preventDefault();
                profileError.textContent = 'Bio tidak boleh lebih dari 500 karakter!';
                profileError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Change password form validation
    const changePasswordForm = document.getElementById('changePasswordForm');
    
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(e) {
            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmNewPassword = document.getElementById('confirmNewPassword').value;
            const passwordError = document.getElementById('passwordError');
            
            if (!currentPassword || !newPassword || !confirmNewPassword) {
                e.preventDefault();
                passwordError.textContent = 'Semua field password harus diisi!';
                passwordError.style.display = 'block';
                return false;
            }
            
            // Password match validation
            if (newPassword !== confirmNewPassword) {
                e.preventDefault();
                passwordError.textContent = 'Password baru dan konfirmasi password tidak cocok!';
                passwordError.style.display = 'block';
                return false;
            }
            
            // Password strength validation
            if (newPassword.length < 8) {
                e.preventDefault();
                passwordError.textContent = 'Password baru harus minimal 8 karakter!';
                passwordError.style.display = 'block';
                return false;
            }
            
            // Check for at least one number and one special character
            const hasNumber = /\d/.test(newPassword);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(newPassword);
            
            if (!hasNumber || !hasSpecial) {
                e.preventDefault();
                passwordError.textContent = 'Password baru harus mengandung minimal 1 angka dan 1 karakter khusus!';
                passwordError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Social media links validation
    const socialLinksForm = document.getElementById('socialLinksForm');
    
    if (socialLinksForm) {
        socialLinksForm.addEventListener('submit', function(e) {
            const linkedinUrl = document.getElementById('linkedinUrl').value;
            const githubUrl = document.getElementById('githubUrl').value;
            const twitterUrl = document.getElementById('twitterUrl').value;
            const socialError = document.getElementById('socialError');
            
            // URL format validation
            const urlRegex = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
            
            if (linkedinUrl && !urlRegex.test(linkedinUrl)) {
                e.preventDefault();
                socialError.textContent = 'Format URL LinkedIn tidak valid!';
                socialError.style.display = 'block';
                return false;
            }
            
            if (githubUrl && !urlRegex.test(githubUrl)) {
                e.preventDefault();
                socialError.textContent = 'Format URL GitHub tidak valid!';
                socialError.style.display = 'block';
                return false;
            }
            
            if (twitterUrl && !urlRegex.test(twitterUrl)) {
                e.preventDefault();
                socialError.textContent = 'Format URL Twitter tidak valid!';
                socialError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Tab navigation
    const profileTabs = document.querySelectorAll('.profile-tab');
    const profileTabContents = document.querySelectorAll('.profile-tab-content');
    
    if (profileTabs.length > 0 && profileTabContents.length > 0) {
        profileTabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all tabs
                profileTabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Hide all tab contents
                profileTabContents.forEach(content => content.style.display = 'none');
                
                // Show the corresponding tab content
                const targetId = this.getAttribute('href').substring(1);
                document.getElementById(targetId).style.display = 'block';
                
                // Update URL hash
                window.location.hash = targetId;
            });
        });
        
        // Check for hash in URL on page load
        if (window.location.hash) {
            const activeTab = document.querySelector(`.profile-tab[href="${window.location.hash}"]`);
            if (activeTab) {
                activeTab.click();
            }
        } else {
            // Activate first tab by default
            profileTabs[0].click();
        }
    }
}); 