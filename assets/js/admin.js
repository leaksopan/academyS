// Admin related JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // Data tables initialization
    const dataTables = document.querySelectorAll('.data-table');
    
    if (dataTables.length > 0) {
        dataTables.forEach(table => {
            $(table).DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    }
    
    // Course form validation
    const courseForm = document.getElementById('courseForm');
    
    if (courseForm) {
        courseForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;
            const level = document.getElementById('level').value;
            const category = document.getElementById('category').value;
            const courseError = document.getElementById('courseError');
            
            if (!title || !description || !level || !category) {
                e.preventDefault();
                courseError.textContent = 'Semua field wajib diisi!';
                courseError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Lesson form validation
    const lessonForm = document.getElementById('lessonForm');
    
    if (lessonForm) {
        lessonForm.addEventListener('submit', function(e) {
            const title = document.getElementById('title').value;
            const content = document.getElementById('content').value;
            const courseId = document.getElementById('course_id').value;
            const lessonError = document.getElementById('lessonError');
            
            if (!title || !content || !courseId) {
                e.preventDefault();
                lessonError.textContent = 'Semua field wajib diisi!';
                lessonError.style.display = 'block';
                return false;
            }
            
            return true;
        });
    }
    
    // Delete confirmation
    const deleteButtons = document.querySelectorAll('.delete-btn');
    
    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const itemId = this.dataset.id;
                const itemType = this.dataset.type;
                const confirmMessage = `Apakah Anda yakin ingin menghapus ${itemType} ini? Tindakan ini tidak dapat dibatalkan.`;
                
                if (confirm(confirmMessage)) {
                    // Send delete request
                    fetch(this.href, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${itemId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove row from table
                            const row = this.closest('tr');
                            if (row) {
                                row.remove();
                            }
                            
                            // Show success message
                            showToast(`${itemType} berhasil dihapus.`, 'success');
                        } else {
                            // Show error message
                            showToast(data.message || `Gagal menghapus ${itemType}.`, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast(`Terjadi kesalahan saat menghapus ${itemType}.`, 'error');
                    });
                }
            });
        });
    }
    
    // Rich text editor initialization
    const richTextEditors = document.querySelectorAll('.rich-text-editor');
    
    if (richTextEditors.length > 0) {
        richTextEditors.forEach(editor => {
            ClassicEditor
                .create(editor, {
                    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'],
                    language: 'id'
                })
                .catch(error => {
                    console.error('Error initializing rich text editor:', error);
                });
        });
    }
    
    // Image preview for course image upload
    const courseImageInput = document.getElementById('course_image');
    const courseImagePreview = document.getElementById('courseImagePreview');
    
    if (courseImageInput && courseImagePreview) {
        courseImageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    courseImagePreview.src = e.target.result;
                    courseImagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Sortable lesson list
    const lessonList = document.getElementById('sortableLessons');
    
    if (lessonList) {
        new Sortable(lessonList, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                // Get new order
                const lessons = Array.from(lessonList.querySelectorAll('li'));
                const lessonOrder = lessons.map((lesson, index) => {
                    return {
                        id: lesson.dataset.id,
                        order: index + 1
                    };
                });
                
                // Send new order to server
                fetch(baseUrl + 'admin/update_lesson_order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        lessons: lessonOrder
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Urutan pelajaran berhasil diperbarui.', 'success');
                    } else {
                        showToast(data.message || 'Gagal memperbarui urutan pelajaran.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat memperbarui urutan pelajaran.', 'error');
                });
            }
        });
    }
    
    // User management
    const userStatusToggles = document.querySelectorAll('.user-status-toggle');
    
    if (userStatusToggles.length > 0) {
        userStatusToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const userId = this.dataset.userId;
                const isActive = this.checked ? 1 : 0;
                
                // Send status update to server
                fetch(baseUrl + 'admin/update_user_status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `user_id=${userId}&is_active=${isActive}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast(`Status pengguna berhasil ${isActive ? 'diaktifkan' : 'dinonaktifkan'}.`, 'success');
                    } else {
                        // Revert toggle if failed
                        this.checked = !this.checked;
                        showToast(data.message || 'Gagal memperbarui status pengguna.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Revert toggle if error
                    this.checked = !this.checked;
                    showToast('Terjadi kesalahan saat memperbarui status pengguna.', 'error');
                });
            });
        });
    }
    
    // Dashboard statistics charts
    const userStatsChart = document.getElementById('userStatsChart');
    
    if (userStatsChart) {
        fetch(baseUrl + 'admin/get_user_stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ctx = userStatsChart.getContext('2d');
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Pengguna Baru',
                                data: data.values,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching user stats:', error);
            });
    }
    
    const courseStatsChart = document.getElementById('courseStatsChart');
    
    if (courseStatsChart) {
        fetch(baseUrl + 'admin/get_course_stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ctx = courseStatsChart.getContext('2d');
                    
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Pendaftaran Kursus',
                                data: data.values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            }
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error fetching course stats:', error);
            });
    }
}); 