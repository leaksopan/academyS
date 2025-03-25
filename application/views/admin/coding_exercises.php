<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Kelola Coding Exercises</h1>
            <p class="text-muted">Kelola latihan coding interaktif untuk pembelajaran.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <a href="<?= base_url('admin/add_coding_exercise') ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Tambah Exercise
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Search & Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/coding_exercises') ?>" method="get" class="row g-3" id="searchForm">
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Exercise</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Cari judul exercise..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="selected_course_display" class="form-label">Filter berdasarkan Kursus</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="selected_course_display" readonly placeholder="Pilih kursus..." 
                            value="<?= isset($_GET['course_id']) && $_GET['course_id'] ? (array_filter($courses, function($c) { return $c['id'] == $_GET['course_id']; }) ? array_values(array_filter($courses, function($c) { return $c['id'] == $_GET['course_id']; }))[0]['title'] : '') : '' ?>">
                        <input type="hidden" name="course_id" id="course_id" value="<?= isset($_GET['course_id']) ? $_GET['course_id'] : '' ?>">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#courseSelectModal">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="language" class="form-label">Filter berdasarkan Bahasa</label>
                    <select name="language" id="language" class="form-select">
                        <option value="">Semua Bahasa</option>
                        <option value="html" <?= isset($_GET['language']) && $_GET['language'] == 'html' ? 'selected' : '' ?>>HTML</option>
                        <option value="css" <?= isset($_GET['language']) && $_GET['language'] == 'css' ? 'selected' : '' ?>>CSS</option>
                        <option value="javascript" <?= isset($_GET['language']) && $_GET['language'] == 'javascript' ? 'selected' : '' ?>>JavaScript</option>
                        <option value="php" <?= isset($_GET['language']) && $_GET['language'] == 'php' ? 'selected' : '' ?>>PHP</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="<?= base_url('admin/coding_exercises') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Course Select Modal -->
    <div class="modal fade" id="courseSelectModal" tabindex="-1" aria-labelledby="courseSelectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseSelectModalLabel">Daftar Pilihan Kursus</h5>
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
                                <input type="text" class="form-control" id="course_search" placeholder="Ketik untuk mencari...">
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="coursesTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 120px">Kode</th>
                                    <th>Nama Kursus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course_item): ?>
                                <tr data-id="<?= $course_item['id'] ?>" data-title="<?= $course_item['title'] ?>" class="course-row">
                                    <td>KURS<?= str_pad($course_item['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                    <td><?= $course_item['title'] ?></td>
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
                    <button type="button" class="btn btn-primary" id="selectCourseBtn">Tetapkan Pilihan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Exercises Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Pelajaran</th>
                            <th>Bahasa</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($exercises)): ?>
                            <?php foreach($exercises as $exercise): ?>
                                <tr>
                                    <td><?= $exercise['id'] ?></td>
                                    <td><?= $exercise['title'] ?></td>
                                    <td><?= $exercise['lesson_title'] ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            switch($exercise['language']) {
                                                case 'html': echo 'danger'; break;
                                                case 'css': echo 'info'; break;
                                                case 'javascript': echo 'warning'; break;
                                                case 'php': echo 'primary'; break;
                                                default: echo 'secondary';
                                            }
                                        ?>">
                                            <?= strtoupper($exercise['language']) ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($exercise['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('coding/exercise/' . $exercise['id']) ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/edit_coding_exercise/' . $exercise['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/delete_coding_exercise/' . $exercise['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus exercise ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data coding exercise</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Variabel untuk menyimpan timeout
    var typingTimer;
    var doneTypingInterval = 500; // waktu dalam ms (0.5 detik)
    
    // Tambahkan style untuk baris yang dipilih
    $('head').append(`
        <style>
            #coursesTable tbody tr.selected {
                background-color: #e2f0ff;
            }
            #coursesTable tbody tr {
                cursor: pointer;
            }
            #coursesTable tbody tr:hover {
                background-color: #f5f5f5;
            }
        </style>
    `);
    
    // Jalankan pencarian saat mengetik di input pencarian
    $('#search').on('keyup', function() {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(submitForm, doneTypingInterval);
    });
    
    // Jalankan pencarian saat memilih filter dropdown
    $('#course_id, #language').on('change', function() {
        submitForm();
    });
    
    // Fungsi untuk submit form
    function submitForm() {
        $('#searchForm').submit();
    }
    
    // Variables for course table pagination
    let currentPage = 1;
    const courses = Array.from(document.querySelectorAll('.course-row'));
    let rowsPerPage = parseInt(document.getElementById('page_size')?.value || 10);
    let filteredCourses = [...courses];
    let selectedCourseId = $('#course_id').val() || null;
    let selectedCourseTitle = $('#selected_course_display').val() || '';
    
    // Initialize pagination if modal exists
    if (courses.length > 0) {
        updateTable();
    }
    
    // Handle page size change
    $('#page_size').on('change', function() {
        rowsPerPage = parseInt($(this).val());
        currentPage = 1;
        updateTable();
    });
    
    // Handle search input
    $('#course_search').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        // Filter courses based on search term
        filteredCourses = courses.filter(course => {
            const courseTitle = course.getAttribute('data-title').toLowerCase();
            const courseId = "KURS" + course.getAttribute('data-id').padStart(3, '0');
            return courseTitle.includes(searchTerm) || courseId.includes(searchTerm);
        });
        
        currentPage = 1;
        updateTable();
    });
    
    // Handle row click for selection
    $(document).on('click', '#coursesTable tbody tr', function() {
        // Remove selected class from all rows
        $('#coursesTable tbody tr').removeClass('selected');
        
        // Add selected class to clicked row
        $(this).addClass('selected');
        
        // Store selected course info
        selectedCourseId = $(this).data('id');
        selectedCourseTitle = $(this).data('title');
    });
    
    // Handle double click for immediate selection
    $(document).on('dblclick', '#coursesTable tbody tr', function() {
        selectedCourseId = $(this).data('id');
        selectedCourseTitle = $(this).data('title');
        
        // Set values and close modal
        $('#course_id').val(selectedCourseId);
        $('#selected_course_display').val(selectedCourseTitle);
        $('#courseSelectModal').modal('hide');
        submitForm(); // Auto-submit form
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
        if (currentPage < Math.ceil(filteredCourses.length / rowsPerPage)) {
            currentPage++;
            updateTable();
        }
    });
    
    // Handle "Tetapkan Pilihan" button click
    $('#selectCourseBtn').on('click', function() {
        if (selectedCourseId) {
            $('#course_id').val(selectedCourseId);
            $('#selected_course_display').val(selectedCourseTitle);
            $('#courseSelectModal').modal('hide');
            submitForm(); // Auto-submit form
        } else {
            alert('Silakan pilih kursus terlebih dahulu');
        }
    });
    
    // Function to update table based on current page, filters, etc.
    function updateTable() {
        if (!filteredCourses || filteredCourses.length === 0) return;
        
        // Hide all rows
        courses.forEach(course => {
            course.style.display = 'none';
        });
        
        // Calculate which rows to show
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(startIndex + rowsPerPage, filteredCourses.length);
        
        // Show rows for current page
        for (let i = startIndex; i < endIndex; i++) {
            filteredCourses[i].style.display = '';
            
            // Add selected class if this row was previously selected
            if (filteredCourses[i].getAttribute('data-id') === selectedCourseId) {
                $(filteredCourses[i]).addClass('selected');
            }
        }
        
        // Update pagination UI
        updatePagination();
    }
    
    // Function to update pagination controls
    function updatePagination() {
        const totalPages = Math.ceil(filteredCourses.length / rowsPerPage);
        
        // Clear existing page links
        const paginationUl = document.querySelector('.pagination');
        if (!paginationUl) return;
        
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
    $('#courseSelectModal').on('shown.bs.modal', function() {
        updateTable();
        $('#course_search').focus();
    });
});
</script> 