// Dashboard related JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Progress chart functionality
    const progressChartCanvas = document.getElementById('progressChart');
    
    if (progressChartCanvas) {
        // Fetch user progress data
        fetch(baseUrl + 'dashboard/get_progress_data')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    renderProgressChart(progressChartCanvas, data.courses);
                }
            })
            .catch(error => {
                console.error('Error fetching progress data:', error);
            });
    }
    
    // Function to render progress chart
    function renderProgressChart(canvas, courses) {
        const ctx = canvas.getContext('2d');
        
        // Prepare data for chart
        const courseNames = courses.map(course => course.title);
        const completionPercentages = courses.map(course => course.completion_percentage);
        
        // Create chart
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: courseNames,
                datasets: [{
                    label: 'Persentase Penyelesaian',
                    data: completionPercentages,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Course continuation functionality
    const continueButtons = document.querySelectorAll('.continue-course');
    
    if (continueButtons.length > 0) {
        continueButtons.forEach(button => {
            button.addEventListener('click', function() {
                const courseId = this.dataset.courseId;
                
                // Fetch next lesson to continue
                fetch(baseUrl + 'dashboard/get_next_lesson', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `course_id=${courseId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.lesson_id) {
                        // Redirect to the lesson
                        window.location.href = baseUrl + 'courses/' + data.course_slug + '/lesson/' + data.lesson_id;
                    } else {
                        // Redirect to course overview
                        window.location.href = baseUrl + 'courses/' + data.course_slug;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback to course overview
                    window.location.href = baseUrl + 'courses/' + courseId;
                });
            });
        });
    }
    
    // Notification handling
    const notificationBell = document.getElementById('notificationBell');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const markAllReadBtn = document.getElementById('markAllRead');
    
    if (notificationBell && notificationDropdown) {
        // Toggle notification dropdown
        notificationBell.addEventListener('click', function(e) {
            e.preventDefault();
            notificationDropdown.classList.toggle('show');
            
            // Mark notifications as seen
            if (notificationDropdown.classList.contains('show')) {
                fetch(baseUrl + 'dashboard/mark_notifications_seen', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update notification count badge
                        const badge = notificationBell.querySelector('.badge');
                        if (badge) {
                            badge.textContent = '0';
                            badge.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error marking notifications as seen:', error);
                });
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationBell.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.remove('show');
            }
        });
        
        // Mark all notifications as read
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                fetch(baseUrl + 'dashboard/mark_all_notifications_read', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI to show all notifications as read
                        const notifications = notificationDropdown.querySelectorAll('.notification-item');
                        notifications.forEach(item => {
                            item.classList.remove('unread');
                            item.classList.add('read');
                        });
                        
                        // Hide mark all read button
                        markAllReadBtn.style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error marking all notifications as read:', error);
                });
            });
        }
    }
}); 