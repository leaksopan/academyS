<div class="container-fluid">
    <style>
        #lessonsTable tbody tr:hover {
            background-color: #f0f7ff;
            cursor: pointer;
        }
        
        #lessonsTable tbody tr.selected {
            background-color: #c2e0ff;
        }
        
        .table-responsive {
            max-height: 350px;
            overflow-y: auto;
        }
        
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
    
    <h1 class="h3 mb-4 text-gray-800">Tambah Quiz</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Quiz Baru</h6>
            <a href="<?php echo base_url('admin/quizzes'); ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
            <?php echo form_open('admin/add_quiz', 'id="quiz_form"'); ?>
                <div class="form-group">
                    <label for="lesson_id">Pilih Pelajaran</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="selected_lesson_display" placeholder="Pilih Pelajaran" readonly data-bs-toggle="modal" data-bs-target="#lessonSelectModal">
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#lessonSelectModal">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="hidden" name="lesson_id" id="lesson_id" value="<?php echo set_value('lesson_id'); ?>" required>
                    </div>
                    <small class="form-text text-muted">Pilih pelajaran yang akan ditambahkan quiz.</small>
                </div>
                
                <!-- Lesson Select Modal -->
                <div class="modal fade" id="lessonSelectModal" tabindex="-1" aria-labelledby="lessonSelectModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="lessonSelectModalLabel">Daftar Pilihan Pelajaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Tampilkan</span>
                                            <select class="form-select" id="page_size">
                                                <option value="5">5</option>
                                                <option value="10" selected>10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select>
                                            <span class="input-group-text">Per Halaman</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text">Cari:</span>
                                            <input type="text" class="form-control" id="lesson_search" placeholder="Ketik untuk mencari...">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="lessonsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 120px">Kode</th>
                                                <th>Kursus</th>
                                                <th>Nama Pelajaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($lessons as $lesson): ?>
                                            <tr data-id="<?php echo $lesson['id']; ?>" data-title="<?php echo $lesson['title']; ?>" data-course="<?php echo $lesson['course_title']; ?>" class="lesson-row">
                                                <td>PLRN<?php echo str_pad($lesson['id'], 3, '0', STR_PAD_LEFT); ?></td>
                                                <td><?php echo $lesson['course_title']; ?></td>
                                                <td><?php echo $lesson['title']; ?></td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="row mt-3">
                                    <div class="col-md-6 d-flex align-items-center">
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination mb-0">
                                                <li class="page-item disabled">
                                                    <a class="page-link" href="#" aria-label="Previous" id="prev-page">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" aria-label="Next" id="next-page">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="selectLessonBtn">Tetapkan Pilihan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="title">Judul Quiz</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo set_value('description'); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="passing_score">Nilai Kelulusan (%)</label>
                    <input type="number" class="form-control" id="passing_score" name="passing_score" value="<?php echo set_value('passing_score', 70); ?>" min="0" max="100" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Quiz</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> 

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables for table pagination
        let currentPage = 1;
        const lessons = Array.from(document.querySelectorAll('.lesson-row'));
        let rowsPerPage = parseInt(document.getElementById('page_size').value);
        let filteredLessons = [...lessons];
        let selectedLessonId = null;
        let selectedLessonTitle = '';
        let selectedLessonCourse = '';
        
        // Pre-select lesson if it was previously selected
        const preselectedLessonId = '<?php echo set_value('lesson_id'); ?>';
        if (preselectedLessonId) {
            $('#lesson_id').val(preselectedLessonId);
            const lessonRow = $(`#lessonsTable tr[data-id="${preselectedLessonId}"]`);
            const lessonTitle = lessonRow.data('title');
            const lessonCourse = lessonRow.data('course');
            $('#selected_lesson_display').val(`${lessonCourse} - ${lessonTitle}`);
            selectedLessonId = preselectedLessonId;
            selectedLessonTitle = lessonTitle;
            selectedLessonCourse = lessonCourse;
            
            // Auto-fill quiz title based on selected lesson
            if ($('#title').val() === '') {
                $('#title').val(`Quiz: ${lessonTitle}`);
            }
            
            // Auto-fill description based on selected lesson
            if ($('#description').val() === '') {
                $('#description').val(`Quiz untuk pelajaran: ${lessonTitle}`);
            }
        }
        
        // Initialize pagination
        updateTable();
        
        // Handle page size change
        $('#page_size').on('change', function() {
            rowsPerPage = parseInt($(this).val());
            currentPage = 1;
            updateTable();
        });
        
        // Handle search input
        $('#lesson_search').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();
            
            // Filter lessons based on search term
            filteredLessons = lessons.filter(lesson => {
                const lessonTitle = lesson.getAttribute('data-title').toLowerCase();
                const lessonCourse = lesson.getAttribute('data-course').toLowerCase();
                const lessonId = "PLRN" + lesson.getAttribute('data-id').padStart(3, '0');
                return lessonTitle.includes(searchTerm) || lessonCourse.includes(searchTerm) || lessonId.includes(searchTerm);
            });
            
            currentPage = 1;
            updateTable();
        });
        
        // Handle row click for selection
        $(document).on('click', '#lessonsTable tbody tr', function() {
            // Remove selected class from all rows
            $('#lessonsTable tbody tr').removeClass('selected');
            
            // Add selected class to clicked row
            $(this).addClass('selected');
            
            // Store selected lesson info
            selectedLessonId = $(this).data('id');
            selectedLessonTitle = $(this).data('title');
            selectedLessonCourse = $(this).data('course');
        });
        
        // Handle double click for immediate selection
        $(document).on('dblclick', '#lessonsTable tbody tr', function() {
            selectedLessonId = $(this).data('id');
            selectedLessonTitle = $(this).data('title');
            selectedLessonCourse = $(this).data('course');
            
            // Set values and close modal
            $('#lesson_id').val(selectedLessonId);
            $('#selected_lesson_display').val(`${selectedLessonCourse} - ${selectedLessonTitle}`);
            
            // Auto-fill quiz title based on selected lesson
            if ($('#title').val() === '') {
                $('#title').val(`Quiz: ${selectedLessonTitle}`);
            }
            
            // Auto-fill description based on selected lesson
            if ($('#description').val() === '') {
                $('#description').val(`Quiz untuk pelajaran: ${selectedLessonTitle}`);
            }
            
            $('#lessonSelectModal').modal('hide');
        });
        
        // Handle pagination clicks
        $('#prev-page').on('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });
        
        $('#next-page').on('click', function(e) {
            e.preventDefault();
            if (currentPage < Math.ceil(filteredLessons.length / rowsPerPage)) {
                currentPage++;
                updateTable();
            }
        });
        
        // Handle "Tetapkan Pilihan" button click
        $('#selectLessonBtn').on('click', function() {
            if (selectedLessonId) {
                $('#lesson_id').val(selectedLessonId);
                $('#selected_lesson_display').val(`${selectedLessonCourse} - ${selectedLessonTitle}`);
                
                // Auto-fill quiz title based on selected lesson
                if ($('#title').val() === '') {
                    $('#title').val(`Quiz: ${selectedLessonTitle}`);
                }
                
                // Auto-fill description based on selected lesson
                if ($('#description').val() === '') {
                    $('#description').val(`Quiz untuk pelajaran: ${selectedLessonTitle}`);
                }
                
                $('#lessonSelectModal').modal('hide');
            } else {
                alert('Silakan pilih pelajaran terlebih dahulu');
            }
        });
        
        // Function to update table based on current page, filters, etc.
        function updateTable() {
            // Hide all rows
            lessons.forEach(lesson => {
                lesson.style.display = 'none';
            });
            
            // Calculate which rows to show
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, filteredLessons.length);
            
            // Show rows for current page
            for (let i = startIndex; i < endIndex; i++) {
                filteredLessons[i].style.display = '';
                
                // Add selected class if this row was previously selected
                if (filteredLessons[i].getAttribute('data-id') === selectedLessonId) {
                    $(filteredLessons[i]).addClass('selected');
                }
            }
            
            // Update pagination UI
            updatePagination();
        }
        
        // Function to update pagination controls
        function updatePagination() {
            const totalPages = Math.ceil(filteredLessons.length / rowsPerPage);
            
            // Clear existing page links
            const paginationUl = document.querySelector('.pagination');
            
            // Keep only first and last items (prev and next buttons)
            while (paginationUl.children.length > 2) {
                paginationUl.removeChild(paginationUl.children[1]);
            }
            
            // Add page links
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                
                const a = document.createElement('a');
                a.className = 'page-link';
                a.href = '#';
                a.textContent = i;
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    currentPage = i;
                    updateTable();
                });
                
                li.appendChild(a);
                paginationUl.insertBefore(li, paginationUl.lastElementChild);
            }
            
            // Update prev/next buttons
            const prevButton = document.getElementById('prev-page').parentNode;
            prevButton.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            
            const nextButton = document.getElementById('next-page').parentNode;
            nextButton.className = `page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}`;
        }
        
        // Initial updating of modal when it opens
        $('#lessonSelectModal').on('shown.bs.modal', function() {
            updateTable();
            $('#lesson_search').focus();
        });
    });
</script> 