// Main JavaScript file for Codecademy Clone

document.addEventListener('DOMContentLoaded', function() {
    // Progress check functionality
    const progressChecks = document.querySelectorAll('.progress-check');
    if (progressChecks.length > 0) {
        progressChecks.forEach(check => {
            check.addEventListener('click', function() {
                const lessonId = this.dataset.lessonId;
                const courseId = this.dataset.courseId;
                const isCompleted = this.checked ? 1 : 0;
                
                // Send AJAX request to update progress
                fetch(baseUrl + 'dashboard/update_progress', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `lesson_id=${lessonId}&course_id=${courseId}&completed=${isCompleted}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Progress updated successfully');
                    } else {
                        console.error('Failed to update progress');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    }
    
    // Course filter functionality
    const levelFilters = document.querySelectorAll('.filter-level');
    const searchInput = document.getElementById('searchCourses');
    const sortSelect = document.getElementById('sortCourses');
    
    if (levelFilters.length > 0 && searchInput && sortSelect) {
        // Filter by level
        levelFilters.forEach(filter => {
            filter.addEventListener('change', filterCourses);
        });
        
        // Search functionality
        searchInput.addEventListener('keyup', filterCourses);
        
        // Sort functionality
        sortSelect.addEventListener('change', sortCourses);
    }
    
    function filterCourses() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedLevels = Array.from(levelFilters)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.value);
        
        const courseItems = document.querySelectorAll('.course-item');
        
        courseItems.forEach(item => {
            const title = item.querySelector('.card-title').textContent.toLowerCase();
            const description = item.querySelector('.card-text').textContent.toLowerCase();
            const level = item.dataset.level;
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesLevel = selectedLevels.length === 0 || selectedLevels.includes(level);
            
            if (matchesSearch && matchesLevel) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    function sortCourses() {
        const courseList = document.getElementById('courseList');
        const courseItems = Array.from(document.querySelectorAll('.course-item'));
        
        courseItems.sort((a, b) => {
            const titleA = a.querySelector('.card-title').textContent;
            const titleB = b.querySelector('.card-title').textContent;
            
            switch (sortSelect.value) {
                case 'az':
                    return titleA.localeCompare(titleB);
                case 'za':
                    return titleB.localeCompare(titleA);
                default:
                    return 0;
            }
        });
        
        courseItems.forEach(item => courseList.appendChild(item));
    }
    
    // Delete account confirmation
    const confirmDeleteInput = document.getElementById('confirmDelete');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    if (confirmDeleteInput && confirmDeleteBtn) {
        confirmDeleteInput.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== 'DELETE';
        });
    }
}); 