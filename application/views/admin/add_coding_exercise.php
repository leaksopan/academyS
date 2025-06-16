<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/theme/monokai.min.css">

<div class="container py-4">
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

    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Tambah Coding Exercise</h1>
            <p class="text-muted">Tambahkan latihan coding interaktif baru.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/coding_exercises') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <?= form_open('admin/add_coding_exercise'); ?>
            <div class="mb-3">
                <label for="title" class="form-label">Judul Exercise</label>
                <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= set_value('title') ?>">
                <div class="invalid-feedback">
                    <?= form_error('title') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="lesson_id" class="form-label">Pelajaran</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="selected_lesson_display" placeholder="Pilih Pelajaran" readonly data-bs-toggle="modal" data-bs-target="#lessonSelectModal">
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#lessonSelectModal">
                        <i class="fas fa-search"></i>
                    </button>
                    <input type="hidden" name="lesson_id" id="lesson_id" value="<?= set_value('lesson_id') ?>">
                </div>
                <div class="invalid-feedback">
                    <?= form_error('lesson_id') ?>
                </div>
            </div>

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
                                            <tr data-id="<?= $lesson['id'] ?>" data-title="<?= $lesson['title'] ?>" data-course="<?= $lesson['course_title'] ?>" class="lesson-row">
                                                <td>PLRN<?= str_pad($lesson['id'], 3, '0', STR_PAD_LEFT) ?></td>
                                                <td><?= $lesson['course_title'] ?></td>
                                                <td><?= $lesson['title'] ?></td>
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

            <div class="mb-3">
                <label for="language" class="form-label">Bahasa Pemrograman</label>
                <select class="form-select <?= form_error('language') ? 'is-invalid' : '' ?>" id="language" name="language">
                    <option value="">Pilih Bahasa</option>
                    <option value="html" <?= set_value('language') == 'html' ? 'selected' : '' ?>>HTML</option>
                    <option value="css" <?= set_value('language') == 'css' ? 'selected' : '' ?>>CSS</option>
                    <option value="javascript" <?= set_value('language') == 'javascript' ? 'selected' : '' ?>>JavaScript</option>
                    <option value="php" <?= set_value('language') == 'php' ? 'selected' : '' ?>>PHP</option>
                </select>
                <div class="invalid-feedback">
                    <?= form_error('language') ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="instructions" class="form-label">Instruksi</label>
                <textarea class="form-control <?= form_error('instructions') ? 'is-invalid' : '' ?>" id="instructions" name="instructions" rows="5"><?= set_value('instructions') ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('instructions') ?>
                </div>
                <small class="text-muted">Gunakan HTML untuk format teks. Jelaskan dengan detail apa yang harus dilakukan siswa.</small>
            </div>

            <div class="mb-3">
                <label for="starter_code" class="form-label">Kode Awal</label>
                <textarea class="form-control code-editor <?= form_error('starter_code') ? 'is-invalid' : '' ?>" id="starter_code" name="starter_code" rows="8"><?= set_value('starter_code') ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('starter_code') ?>
                </div>
                <small class="text-muted">Kode awal yang akan ditampilkan kepada siswa.</small>
            </div>

            <div class="mb-3">
                <label for="solution_code" class="form-label">Kode Solusi</label>
                <textarea class="form-control code-editor <?= form_error('solution_code') ? 'is-invalid' : '' ?>" id="solution_code" name="solution_code" rows="8"><?= set_value('solution_code') ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('solution_code') ?>
                </div>
                <small class="text-muted">Kode solusi yang benar untuk perbandingan.</small>
            </div>

            <div class="mb-3">
                <label for="test_cases" class="form-label">Test Cases (Opsional)</label>
                <textarea class="form-control <?= form_error('test_cases') ? 'is-invalid' : '' ?>" id="test_cases" name="test_cases" rows="5"><?= set_value('test_cases') ?></textarea>
                <div class="invalid-feedback">
                    <?= form_error('test_cases') ?>
                </div>
                <small class="text-muted">Format JSON. Contoh: [{"input": "2, 3", "expected": "5"}, {"input": "5, 5", "expected": "10"}]</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Exercise</button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/codemirror.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/edit/matchbrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/mode/overlay.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/mode/multiplex.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/php/php.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var starterCodeEditor = null;
        var solutionCodeEditor = null;
        var editorsInitialized = false;

        document.querySelectorAll('.CodeMirror').forEach(function(cmEl) {
            cmEl.remove();
        });

        setTimeout(function() {
            initializeEditors();

            var languageSelect = document.getElementById('language');
            if (languageSelect) {
                languageSelect.addEventListener('change', initializeEditors);
            }
        }, 300);

        function initializeEditors() {
            try {
                clearExistingEditors();

                console.log('Initializing CodeMirror editors...');

                var languageSelect = document.getElementById('language');
                var language = languageSelect ? languageSelect.value : 'javascript';
                var mode;

                switch (language) {
                    case 'html':
                        mode = 'htmlmixed';
                        break;
                    case 'css':
                        mode = 'text/css';
                        break;
                    case 'javascript':
                        mode = 'text/javascript';
                        break;
                    case 'php':
                        mode = 'text/x-php';
                        break;
                    default:
                        mode = 'text/javascript';
                }

                console.log('Using mode: ', mode);

                var starterCodeTextarea = document.getElementById('starter_code');
                if (starterCodeTextarea) {
                    starterCodeTextarea.style.display = 'block';

                    var editorOptions = {
                        lineNumbers: true,
                        mode: mode,
                        theme: 'monokai',
                        matchBrackets: true,
                        autoCloseBrackets: true,
                        indentUnit: 4,
                        indentWithTabs: false,
                        extraKeys: {
                            "Enter": function(cm) {
                                cm.replaceSelection("\n");
                            }
                        }
                    };

                    if (language === 'php') {
                        editorOptions.matchBrackets = true;
                        editorOptions.autoCloseBrackets = true;
                        editorOptions.indentWithTabs = true;
                    }

                    starterCodeEditor = CodeMirror.fromTextArea(starterCodeTextarea, editorOptions);
                    console.log('Starter code editor initialized with mode ', mode);

                    if (language === 'php') {
                        starterCodeEditor.on('change', function() {
                            starterCodeTextarea.value = starterCodeEditor.getValue();
                        });
                    }
                }

                var solutionCodeTextarea = document.getElementById('solution_code');
                if (solutionCodeTextarea) {
                    solutionCodeTextarea.style.display = 'block';

                    var editorOptions = {
                        lineNumbers: true,
                        mode: mode,
                        theme: 'monokai',
                        matchBrackets: true,
                        autoCloseBrackets: true,
                        indentUnit: 4,
                        indentWithTabs: false,
                        extraKeys: {
                            "Enter": function(cm) {
                                cm.replaceSelection("\n");
                            }
                        }
                    };

                    if (language === 'php') {
                        editorOptions.matchBrackets = true;
                        editorOptions.autoCloseBrackets = true;
                        editorOptions.indentWithTabs = true;
                    }

                    solutionCodeEditor = CodeMirror.fromTextArea(solutionCodeTextarea, editorOptions);
                    console.log('Solution code editor initialized with mode ', mode);

                    if (language === 'php') {
                        solutionCodeEditor.on('change', function() {
                            solutionCodeTextarea.value = solutionCodeEditor.getValue();
                        });
                    }
                }

                editorsInitialized = true;
            } catch (error) {
                console.error('Error initializing CodeMirror:', error);
            }
        }

        function clearExistingEditors() {
            document.querySelectorAll('.CodeMirror').forEach(function(cmEl) {
                cmEl.remove();
            });

            document.querySelectorAll('.code-editor').forEach(function(textarea) {
                textarea.style.display = 'block';
            });

            starterCodeEditor = null;
            solutionCodeEditor = null;
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentPage = 1;
        const lessons = Array.from(document.querySelectorAll('.lesson-row'));
        let rowsPerPage = parseInt(document.getElementById('page_size').value);
        let filteredLessons = [...lessons];
        let selectedLessonId = null;
        let selectedLessonTitle = '';
        let selectedLessonCourse = '';

        const preselectedLessonId = '<?= set_value('lesson_id') ?>';
        if (preselectedLessonId) {
            $('#lesson_id').val(preselectedLessonId);
            const lessonRow = $(`#lessonsTable tr[data-id="${preselectedLessonId}"]`);
            const lessonTitle = lessonRow.data('title');
            const lessonCourse = lessonRow.data('course');
            $('#selected_lesson_display').val(`${lessonCourse} - ${lessonTitle}`);
            selectedLessonId = preselectedLessonId;
            selectedLessonTitle = lessonTitle;
            selectedLessonCourse = lessonCourse;
        }

        updateTable();

        $('#page_size').on('change', function() {
            rowsPerPage = parseInt($(this).val());
            currentPage = 1;
            updateTable();
        });

        $('#lesson_search').on('keyup', function() {
            const searchTerm = $(this).val().toLowerCase();

            filteredLessons = lessons.filter(lesson => {
                const lessonTitle = lesson.getAttribute('data-title').toLowerCase();
                const lessonCourse = lesson.getAttribute('data-course').toLowerCase();
                const lessonId = "PLRN" + lesson.getAttribute('data-id').padStart(3, '0');
                return lessonTitle.includes(searchTerm) || lessonCourse.includes(searchTerm) || lessonId.includes(searchTerm);
            });

            currentPage = 1;
            updateTable();
        });

        $(document).on('click', '#lessonsTable tbody tr', function() {
            $('#lessonsTable tbody tr').removeClass('selected');

            $(this).addClass('selected');

            selectedLessonId = $(this).data('id');
            selectedLessonTitle = $(this).data('title');
            selectedLessonCourse = $(this).data('course');
        });

        $(document).on('dblclick', '#lessonsTable tbody tr', function() {
            selectedLessonId = $(this).data('id');
            selectedLessonTitle = $(this).data('title');
            selectedLessonCourse = $(this).data('course');

            $('#lesson_id').val(selectedLessonId);
            $('#selected_lesson_display').val(`${selectedLessonCourse} - ${selectedLessonTitle}`);
            $('#lessonSelectModal').modal('hide');
        });

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

        $('#selectLessonBtn').on('click', function() {
            if (selectedLessonId) {
                $('#lesson_id').val(selectedLessonId);
                $('#selected_lesson_display').val(`${selectedLessonCourse} - ${selectedLessonTitle}`);
                $('#lessonSelectModal').modal('hide');
            } else {
                alert('Silakan pilih pelajaran terlebih dahulu');
            }
        });

        function updateTable() {
            lessons.forEach(lesson => {
                lesson.style.display = 'none';
            });

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, filteredLessons.length);

            for (let i = startIndex; i < endIndex; i++) {
                filteredLessons[i].style.display = '';

                if (filteredLessons[i].getAttribute('data-id') === selectedLessonId) {
                    $(filteredLessons[i]).addClass('selected');
                }
            }

            updatePagination();
        }

        function updatePagination() {
            const totalPages = Math.ceil(filteredLessons.length / rowsPerPage);

            const paginationUl = document.querySelector('.pagination');

            while (paginationUl.children.length > 2) {
                paginationUl.removeChild(paginationUl.children[1]);
            }

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

            const prevButton = document.getElementById('prev-page').parentNode;
            prevButton.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;

            const nextButton = document.getElementById('next-page').parentNode;
            nextButton.className = `page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}`;
        }

        $('#lessonSelectModal').on('shown.bs.modal', function() {
            updateTable();
            $('#lesson_search').focus();
        });
    });
</script>