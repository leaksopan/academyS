<!-- Load CodeMirror CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/theme/monokai.min.css">

<div class="container py-4">
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
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Add Exercise Form -->
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
                    <select class="form-select <?= form_error('lesson_id') ? 'is-invalid' : '' ?>" id="lesson_id" name="lesson_id">
                        <option value="">Pilih Pelajaran</option>
                        <?php foreach($lessons as $lesson): ?>
                            <option value="<?= $lesson['id'] ?>" <?= set_value('lesson_id') == $lesson['id'] ? 'selected' : '' ?>>
                                <?= $lesson['title'] ?> (<?= $lesson['course_title'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= form_error('lesson_id') ?>
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

<!-- Load CodeMirror JS -->
<!-- Urutan load harus diperhatikan -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/codemirror.min.js"></script>
<!-- Addon-addon yang diperlukan -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/edit/matchbrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/edit/closebrackets.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/mode/overlay.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/mode/multiplex.min.js"></script>
<!-- Mode-mode coding -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/xml/xml.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/javascript/javascript.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/css/css.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/clike/clike.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/htmlmixed/htmlmixed.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/php/php.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variabel global untuk menyimpan instance editor
    var starterCodeEditor = null;
    var solutionCodeEditor = null;
    
    // Flag untuk menandai apakah editor sudah diinisialisasi
    var editorsInitialized = false;
    
    // Hapus semua instance CodeMirror yang mungkin sudah ada
    document.querySelectorAll('.CodeMirror').forEach(function(cmEl) {
        cmEl.remove();
    });
    
    // Tunda inisialisasi editor untuk mencegah duplikasi
    setTimeout(function() {
        // Inisialisasi editor 
        initializeEditors();
        
        // Tambahkan event listener untuk perubahan bahasa
        var languageSelect = document.getElementById('language');
        if (languageSelect) {
            languageSelect.addEventListener('change', initializeEditors);
        }
    }, 300); // Menambah penundaan ke 300ms
    
    // Fungsi untuk inisialisasi editor
    function initializeEditors() {
        try {
            // Hapus kemungkinan editor yang sudah ada
            clearExistingEditors();
            
            console.log('Initializing CodeMirror editors...');
            
            // Dapatkan bahasa yang dipilih
            var languageSelect = document.getElementById('language');
            var language = languageSelect ? languageSelect.value : 'javascript';
            var mode;
            
            // Konfigurasi mode yang tepat untuk setiap bahasa
            switch(language) {
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
                    // Mode khusus untuk PHP
                    mode = 'text/x-php';
                    break;
                default: 
                    mode = 'text/javascript';
            }
            
            console.log('Using mode: ', mode);
            
            // Setup starter code editor
            var starterCodeTextarea = document.getElementById('starter_code');
            if (starterCodeTextarea) {
                // Pastikan textarea terlihat
                starterCodeTextarea.style.display = 'block';
                
                // Opsi tambahan untuk PHP
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
                
                // Tambahkan opsi khusus untuk PHP
                if (language === 'php') {
                    editorOptions.matchBrackets = true;
                    editorOptions.autoCloseBrackets = true;
                    editorOptions.indentWithTabs = true; // Untuk PHP biasanya gunakan tab
                }
                
                // Reinisialisasi editor
                starterCodeEditor = CodeMirror.fromTextArea(starterCodeTextarea, editorOptions);
                console.log('Starter code editor initialized with mode ', mode);
                
                // Atur event untuk mengupdate value saat mode PHP
                if (language === 'php') {
                    starterCodeEditor.on('change', function() {
                        starterCodeTextarea.value = starterCodeEditor.getValue();
                    });
                }
            }
            
            // Setup solution code editor
            var solutionCodeTextarea = document.getElementById('solution_code');
            if (solutionCodeTextarea) {
                // Pastikan textarea terlihat
                solutionCodeTextarea.style.display = 'block';
                
                // Opsi tambahan untuk PHP
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
                
                // Tambahkan opsi khusus untuk PHP
                if (language === 'php') {
                    editorOptions.matchBrackets = true;
                    editorOptions.autoCloseBrackets = true;
                    editorOptions.indentWithTabs = true; // Untuk PHP biasanya gunakan tab
                }
                
                // Reinisialisasi editor
                solutionCodeEditor = CodeMirror.fromTextArea(solutionCodeTextarea, editorOptions);
                console.log('Solution code editor initialized with mode ', mode);
                
                // Atur event untuk mengupdate value saat mode PHP
                if (language === 'php') {
                    solutionCodeEditor.on('change', function() {
                        solutionCodeTextarea.value = solutionCodeEditor.getValue();
                    });
                }
            }
            
            // Set flag bahwa editor sudah diinisialisasi
            editorsInitialized = true;
        } catch (error) {
            console.error('Error initializing CodeMirror:', error);
        }
    }
    
    // Fungsi untuk membersihkan editor yang ada
    function clearExistingEditors() {
        // Hapus semua instance CodeMirror yang ada
        document.querySelectorAll('.CodeMirror').forEach(function(cmEl) {
            cmEl.remove();
        });
        
        // Reset textarea agar terlihat
        document.querySelectorAll('.code-editor').forEach(function(textarea) {
            textarea.style.display = 'block';
        });
        
        // Reset variabel editor
        starterCodeEditor = null;
        solutionCodeEditor = null;
    }
});
</script> 