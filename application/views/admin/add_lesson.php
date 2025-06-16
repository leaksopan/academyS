<div class="container py-4">
    <style>
        #coursesTable tbody tr:hover {
            background-color: #f0f7ff;
            cursor: pointer;
        }

        #coursesTable tbody tr.selected {
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

    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Tambah Pelajaran</h1>
            <?php if (isset($course) && $course): ?>
                <p class="text-muted">Tambahkan pelajaran baru untuk kursus: <strong><?= $course['title'] ?></strong></p>
            <?php else: ?>
                <p class="text-muted">Tambahkan pelajaran baru</p>
            <?php endif; ?>
        </div>
        <div class="col-md-4 text-end">
            <?php if (isset($course_id) && $course_id): ?>
                <a href="<?= base_url('admin/lessons?course_id=' . $course_id) ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pelajaran
                </a>
            <?php else: ?>
                <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kursus
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('lesson_add_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('lesson_add_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Add Lesson Form -->
    <div class="card">
        <div class="card-body">
            <?php
            $form_url = 'admin/add_lesson';
            echo form_open($form_url);
            ?>
            <?php if (isset($course_id) && $course_id): ?>
                <input type="hidden" name="course_id" value="<?= $course_id ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label for="title" class="form-label">Judul Pelajaran</label>
                <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= set_value('title') ?>">
                <div class="invalid-feedback">
                    <?= form_error('title') ?>
                </div>
            </div>

            <?php if (!isset($course_id) || !$course_id): ?>
                <div class="mb-3">
                    <label for="course_id" class="form-label">Kursus</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="selected_course_display" placeholder="Pilih Kursus" readonly data-bs-toggle="modal" data-bs-target="#courseSelectModal">
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#courseSelectModal">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="hidden" name="course_id" id="course_id" value="<?= set_value('course_id') ?>">
                    </div>
                    <?php if (form_error('course_id')): ?>
                        <div class="text-danger">
                            <?= form_error('course_id') ?>
                        </div>
                    <?php endif; ?>
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
                                <button type="button" class="btn btn-primary" id="selectCourseBtn">Tetapkan Pilihan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="order_number" class="form-label">Urutan</label>
                <input type="number" class="form-control <?= form_error('order_number') ? 'is-invalid' : '' ?>" id="order_number" name="order_number" value="<?= set_value('order_number') ?>">
                <div class="invalid-feedback">
                    <?= form_error('order_number') ?>
                </div>
                <small class="text-muted">Urutan pelajaran dalam kursus (1, 2, 3, dst.)</small>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Konten Pelajaran</label>
                <textarea class="form-control <?= form_error('content') ? 'is-invalid' : '' ?>" id="content" name="content" rows="10"><?= set_value('content') ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('content') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="video_url" class="form-label">URL Video YouTube</label>
                <input type="text" class="form-control <?= form_error('video_url') ? 'is-invalid' : '' ?>" id="video_url" name="video_url" value="<?= set_value('video_url') ?>">
                <div class="invalid-feedback">
                    <?= form_error('video_url') ?>
                </div>
                <small class="text-muted">Masukkan URL video YouTube (contoh: https://www.youtube.com/watch?v=VIDEO_ID atau https://youtu.be/VIDEO_ID)</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pelajaran</button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    // Initialize CKEditor for rich text editing
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('content', {
                height: 400,
                removeButtons: 'About',
                allowedContent: true
            });
        }

        // Variables for table pagination
        let currentPage = 1;
        const courses = Array.from(document.querySelectorAll('.course-row'));
        let rowsPerPage = parseInt(document.getElementById('page_size').value);
        let filteredCourses = [...courses];
        let selectedCourseId = null;
        let selectedCourseTitle = '';

        // Pre-select course if it was previously selected
        const preselectedCourseId = '<?= set_value('course_id') ?>';
        if (preselectedCourseId) {
            $('#course_id').val(preselectedCourseId);
            const courseTitle = $(`#coursesTable tr[data-id="${preselectedCourseId}"]`).data('title');
            $('#selected_course_display').val(courseTitle);
            selectedCourseId = preselectedCourseId;
            selectedCourseTitle = courseTitle;
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
            } else {
                alert('Silakan pilih kursus terlebih dahulu');
            }
        });

        // Function to update table based on current page, filters, etc.
        function updateTable() {
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