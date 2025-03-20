<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-2"><?= $exercise['title'] ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('courses/view/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('courses/lesson/' . $lesson['id']) ?>"><?= $lesson['title'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Coding Exercise</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('courses/lesson/' . $lesson['id']) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Pelajaran
            </a>
        </div>
    </div>
    
    <div class="row">
        <!-- Instruksi Panel (Kiri) -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Instruksi</h5>
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
                </div>
                <div class="card-body">
                    <div class="instructions mb-4">
                        <?= $exercise['instructions'] ?>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button id="runCode" class="btn btn-primary">
                            <i class="fas fa-play me-2"></i> Jalankan Kode
                        </button>
                        <button id="submitCode" class="btn btn-success">
                            <i class="fas fa-check me-2"></i> Submit
                        </button>
                        <button id="resetCode" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i> Reset Kode
                        </button>
                        
                        <!-- Tombol untuk lihat solusi (hidden by default) -->
                        <button id="showSolution" class="btn btn-warning mt-3 d-none">
                            <i class="fas fa-lightbulb me-2"></i> Lihat Solusi
                        </button>
                    </div>
                    
                    <?php if(!empty($submission) && $submission['is_correct']): ?>
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-circle me-2"></i> Anda telah berhasil menyelesaikan exercise ini!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Editor Panel (Tengah) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Editor Kode</h5>
                </div>
                <div class="card-body p-0">
                    <div id="codeEditor" style="height: 1000px; width: 100%;"></div>
                </div>
            </div>
        </div>
        
        <!-- Output Panel (Kanan) -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Output</h5>
                </div>
                <div class="card-body p-0">
                    <div id="output" class="p-3 bg-light text-dark" style="min-height: 1000px; font-family: monospace; white-space: pre-wrap; overflow-x: auto;">
                        <!-- Output akan ditampilkan di sini -->
                        <div class="text-muted">Output akan ditampilkan di sini setelah kode dijalankan...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load CodeMirror CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/codemirror.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/theme/monokai.min.css">

<!-- Load jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<style>
/* Pengaturan tambahan untuk CodeMirror */
.CodeMirror {
    height: auto;
    min-height: 1000px;
    font-size: 16px;
    line-height: 1.5;
}
.CodeMirror-scroll {
    min-height: 1000px;
}
</style>

<!-- Load CodeMirror JS - Menggunakan versi non-minified untuk debugging -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/codemirror.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/clike/clike.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/php/php.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/xml/xml.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/javascript/javascript.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/css/css.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/mode/htmlmixed/htmlmixed.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/edit/matchbrackets.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/edit/closebrackets.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/mode/overlay.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.11/addon/mode/multiplex.js"></script>

<script>
// Variabel global untuk menyimpan instance editor
var codeEditor = null;
var isUsingPHP = false;

// Fungsi untuk mendapatkan solusi - pindahkan ke global scope
function getSolution() {
    const outputDiv = document.getElementById('output');
    if (!outputDiv) {
        console.error('Output div not found');
        return;
    }
    
    outputDiv.innerHTML = '<div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div>';
    
    fetch('<?= base_url('coding/get_solution') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            'exercise_id': <?= $exercise['id'] ?>
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            outputDiv.innerHTML = `<div class="alert alert-danger mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i> ${data.error}
            </div>`;
        } else {
            outputDiv.innerHTML = `<div class="alert alert-warning mb-0">
                <i class="fas fa-lightbulb me-2"></i> ${data.message}
            </div>`;
            
            // Tambahkan kode solusi ke editor dengan highlight sementara
            if (codeEditor && data.solution) {
                // Simpan posisi cursor
                const currentPosition = codeEditor.getCursor();
                
                // Set nilai solusi
                codeEditor.setValue(data.solution);
                
                // Highlight seluruh kode sebagai visual cue
                codeEditor.setSelection({line: 0, ch: 0}, {line: codeEditor.lineCount(), ch: 0});
                
                // Reset selection setelah beberapa saat
                setTimeout(() => {
                    codeEditor.setCursor(currentPosition);
                }, 1000);
                
                // Log aktivitas
                console.log('Solution viewed for exercise ID: <?= $exercise['id'] ?>');
            }
        }
    })
    .catch(error => {
        console.error('Error fetching solution:', error);
        outputDiv.innerHTML = `<div class="alert alert-danger mb-0">
            <i class="fas fa-exclamation-triangle me-2"></i> Error: ${error.message}
        </div>`;
    });
}

// Tambahkan opsi passive untuk event listener
function addPassiveSupport() {
    // Deteksi dukungan passive event listener
    let supportsPassive = false;
    try {
        const opts = Object.defineProperty({}, 'passive', {
            get: function() {
                supportsPassive = true;
                return true;
            }
        });
        window.addEventListener('testPassive', null, opts);
        window.removeEventListener('testPassive', null, opts);
    } catch (e) {}
    
    // Tambahkan ke CodeMirror jika didukung
    if (supportsPassive) {
        CodeMirror.passiveEvents = true;
    }
}

// Tunggu hingga window selesai dimuat
window.onload = function() {
    try {
        console.log('Initializing CodeMirror editor...');
        
        // Tambahkan dukungan passive event listener
        addPassiveSupport();
        
        // Inisialisasi editor
        const language = '<?= $exercise['language'] ?>';
        let mode;
        isUsingPHP = (language === 'php');
        
        switch(language) {
            case 'html': mode = 'text/html'; break;
            case 'css': mode = 'text/css'; break;
            case 'javascript': mode = 'text/javascript'; break;
            case 'php': mode = 'text/x-php'; break;
            default: mode = 'text/javascript';
        }
        
        console.log('Using mode: ' + mode);
        
        var codeEditorDiv = document.getElementById('codeEditor');
        if (codeEditorDiv && !codeEditor) {
            console.log('Found codeEditor div, initializing...');
            
            // Hapus editor sebelumnya jika ada
            if (codeEditorDiv.firstChild) {
                while (codeEditorDiv.firstChild) {
                    codeEditorDiv.removeChild(codeEditorDiv.firstChild);
                }
            }
            
            // Konfigurasi editor dengan pengaturan indentasi yang tepat
            codeEditor = CodeMirror(codeEditorDiv, {
                value: `<?= addslashes($exercise['starter_code']) ?>`,
                mode: mode,
                theme: 'monokai',
                lineNumbers: true,
                indentUnit: 2,
                smartIndent: false, // Matikan smartIndent untuk menghindari masalah indentasi
                indentWithTabs: false,
                electricChars: false, // Matikan electricChars untuk menghindari masalah indentasi
                autoCloseBrackets: true,
                matchBrackets: true,
                viewportMargin: Infinity,
                lineWrapping: true,
                tabSize: 2,
                autofocus: true, // Fokus otomatis ke editor
                scrollbarStyle: "native", // Gunakan scrollbar native untuk performa lebih baik
                extraKeys: {
                    "Enter": function(cm) {
                        // Gunakan pendekatan yang lebih sederhana untuk newline
                        var cursor = cm.getCursor();
                        var line = cm.getLine(cursor.line);
                        var indentation = line.match(/^\s*/)[0];
                        cm.replaceSelection("\n" + indentation);
                        return false; // Penting: hentikan propagasi event
                    },
                    "Tab": function(cm) {
                        if (cm.somethingSelected()) {
                            cm.indentSelection("add");
                        } else {
                            cm.replaceSelection("  "); // 2 spasi untuk indentasi
                        }
                        return false;
                    },
                    "Ctrl-S": function(cm) {
                        // Mencegah browser menyimpan halaman saat Ctrl+S ditekan
                        if (submitCodeBtn) {
                            submitCodeBtn.click(); // Submit kode saat Ctrl+S ditekan
                        }
                        return false;
                    },
                    "Ctrl-Enter": function(cm) {
                        // Jalankan kode saat Ctrl+Enter ditekan
                        if (runCodeBtn) {
                            runCodeBtn.click();
                        }
                        return false;
                    }
                }
            });
            
            // Tambahkan event listener untuk mencegah error indentasi
            codeEditor.on("beforeChange", function(cm, change) {
                // Jika perubahan adalah newline, tangani secara manual
                if (change.origin === "+input" && change.text.length === 1 && change.text[0] === "") {
                    // Ini adalah penghapusan, biarkan terjadi
                    return;
                }
            });
            
            console.log('Code editor initialized');
            
            // Atur tinggi editor untuk menampilkan minimal 24 baris
            const lineHeight = codeEditor.defaultTextHeight();
            const padding = 20; // Padding tambahan
            const minHeight = (24 * lineHeight) + padding;
            codeEditor.setSize(null, minHeight > 1000 ? minHeight : 1000);
            
            // Jika ada submission sebelumnya, gunakan kode tersebut
            <?php if(!empty($submission)): ?>
            codeEditor.setValue(`<?= addslashes($submission['code']) ?>`);
            <?php endif; ?>
            
            // Run Code
            var runCodeBtn = document.getElementById('runCode');
            if (runCodeBtn) {
                runCodeBtn.addEventListener('click', function() {
                    const code = codeEditor.getValue();
                    
                    // Untuk JavaScript, HTML, CSS - jalankan di browser
                    if (['javascript', 'html', 'css'].includes(language)) {
                        executeInBrowser(code, language);
                    } else {
                        // Untuk PHP - kirim ke server
                        executeOnServer(code, language);
                    }
                });
            }
            
            // Submit Code
            var submitCodeBtn = document.getElementById('submitCode');
            if (submitCodeBtn) {
                submitCodeBtn.addEventListener('click', function() {
                    const code = codeEditor.getValue();
                    const outputDiv = document.getElementById('output');
                    
                    if (!outputDiv) {
                        console.error('Output div not found');
                        return;
                    }
                    
                    outputDiv.innerHTML = '<div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div>';
                    
                    fetch('<?= base_url('coding/submit') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({
                            'exercise_id': <?= $exercise['id'] ?>,
                            'code': code
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.is_correct) {
                            outputDiv.innerHTML = `<div class="alert alert-success mb-0">
                                <i class="fas fa-check-circle me-2"></i> ${data.message}
                            </div>`;
                            
                            // Tambahkan alert sukses di atas editor
                            const instructionsDiv = document.querySelector('.instructions');
                            if (instructionsDiv) {
                                const alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-success alert-dismissible fade show';
                                alertDiv.innerHTML = `
                                    <i class="fas fa-check-circle me-2"></i> ${data.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                `;
                                
                                instructionsDiv.insertAdjacentElement('beforebegin', alertDiv);
                                
                                // Auto dismiss after 5 seconds
                                setTimeout(() => {
                                    alertDiv.classList.remove('show');
                                    setTimeout(() => alertDiv.remove(), 150);
                                }, 5000);
                            }
                        } else {
                            outputDiv.innerHTML = `<div class="alert alert-danger mb-0">
                                <i class="fas fa-times-circle me-2"></i> ${data.message}
                            </div>`;
                            
                            // CEK APAKAH PERLU MENAMPILKAN TOMBOL SOLUSI
                            if (data.show_solution_btn) {
                                // Tambahkan pesan attempts ke output
                                outputDiv.innerHTML += `<div class="alert alert-info mt-2 mb-0">
                                    <i class="fas fa-info-circle me-2"></i> Kamu telah mencoba ${data.attempts} kali. Kamu bisa melihat solusi jika diperlukan.
                                </div>`;
                                
                                // Tampilkan tombol solution jika belum ditampilkan
                                var showSolutionBtn = document.getElementById('showSolution');
                                if (showSolutionBtn) {
                                    showSolutionBtn.classList.remove('d-none');
                                    
                                    // Pastikan event listener hanya ditambahkan sekali
                                    if (!showSolutionBtn.hasAttribute('data-initialized')) {
                                        showSolutionBtn.setAttribute('data-initialized', 'true');
                                        showSolutionBtn.addEventListener('click', function() {
                                            if (confirm('Yakin ingin melihat solusi? Lebih baik mencoba sendiri sebisa mungkin.')) {
                                                getSolution();
                                            }
                                        });
                                    }
                                    
                                    // Beri tahu user bahwa tombol solusi sudah tersedia
                                    const instructionsDiv = document.querySelector('.instructions');
                                    if (instructionsDiv) {
                                        const notifDiv = document.createElement('div');
                                        notifDiv.className = 'alert alert-warning alert-dismissible fade show mt-3';
                                        notifDiv.innerHTML = `
                                            <i class="fas fa-lightbulb me-2"></i> Tombol "Lihat Solusi" sudah tersedia di bawah jika kamu membutuhkannya.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        `;
                                        
                                        // Cek apakah notifikasi sudah ada
                                        if (!document.querySelector('.alert-warning.mt-3')) {
                                            instructionsDiv.insertAdjacentElement('afterend', notifDiv);
                                        
                                            // Auto dismiss after 8 seconds
                                            setTimeout(() => {
                                                notifDiv.classList.remove('show');
                                                setTimeout(() => notifDiv.remove(), 150);
                                            }, 8000);
                                        }
                                    }
                                }
                            }
                        }
                    })
                    .catch(error => {
                        outputDiv.innerHTML = `<div class="alert alert-danger mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i> Error: ${error.message}
                        </div>`;
                    });
                });
            }
            
            // Reset Code
            var resetCodeBtn = document.getElementById('resetCode');
            if (resetCodeBtn) {
                resetCodeBtn.addEventListener('click', function() {
                    if (confirm('Yakin ingin mereset kode ke kondisi awal?')) {
                        codeEditor.setValue(`<?= addslashes($exercise['starter_code']) ?>`);
                    }
                });
            }
        } else {
            console.error('codeEditor div not found or editor already initialized');
        }
        
        // Fungsi untuk eksekusi di browser
        function executeInBrowser(code, language) {
            const outputDiv = document.getElementById('output');
            if (!outputDiv) {
                console.error('Output div not found');
                return;
            }
            
            outputDiv.innerHTML = '';
            
            if (language === 'javascript') {
                try {
                    // Jalankan dalam sandbox
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    document.body.appendChild(iframe);
                    
                    // Redirect console.log ke output kita
                    const originalConsoleLog = iframe.contentWindow.console.log;
                    iframe.contentWindow.console.log = function() {
                        const args = Array.from(arguments);
                        outputDiv.innerHTML += args.join(' ') + '<br>';
                        originalConsoleLog.apply(iframe.contentWindow.console, arguments);
                    };
                    
                    // Jalankan kode
                    iframe.contentWindow.eval(code);
                    
                    // Cleanup
                    setTimeout(() => {
                        document.body.removeChild(iframe);
                    }, 100);
                    
                    if (outputDiv.innerHTML === '') {
                        outputDiv.innerHTML = '<span class="text-muted">Kode dijalankan tanpa output.</span>';
                    }
                } catch (error) {
                    outputDiv.innerHTML = `<span class="text-danger">Error: ${error.message}</span>`;
                }
            } else if (language === 'html' || language === 'css') {
                // Untuk HTML/CSS, tampilkan dalam iframe
                const iframe = document.createElement('iframe');
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                iframe.style.border = 'none';
                iframe.style.minHeight = '900px';
                
                outputDiv.innerHTML = '';
                outputDiv.appendChild(iframe);
                
                const doc = iframe.contentDocument || iframe.contentWindow.document;
                doc.open();
                
                // Jika CSS, bungkus dalam HTML
                if (language === 'css') {
                    doc.write(`
                        <!DOCTYPE html>
                        <html>
                        <head>
                            <style>${code}</style>
                        </head>
                        <body>
                            <div class="container">
                                <h1>Heading 1</h1>
                                <p>Paragraph text</p>
                                <button>Button</button>
                                <ul>
                                    <li>Item 1</li>
                                    <li>Item 2</li>
                                    <li>Item 3</li>
                                </ul>
                            </div>
                        </body>
                        </html>
                    `);
                } else {
                    doc.write(code);
                }
                
                doc.close();
            }
        }
        
        // Fungsi untuk eksekusi di server (PHP)
        function executeOnServer(code, language) {
            const outputDiv = document.getElementById('output');
            if (!outputDiv) {
                console.error('Output div not found');
                return;
            }
            
            outputDiv.innerHTML = '<div class="spinner-border text-dark" role="status"><span class="visually-hidden">Loading...</span></div>';
            
            fetch('<?= base_url('coding/execute') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    'code': code,
                    'language': language
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    outputDiv.innerHTML = `<span class="text-danger">${data.error}</span>`;
                } else {
                    outputDiv.innerHTML = `<pre class="mb-0">${data.output || '<span class="text-muted">Kode dijalankan tanpa output.</span>'}</pre>`;
                }
            })
            .catch(error => {
                outputDiv.innerHTML = `<span class="text-danger">Error: ${error.message}</span>`;
            });
        }
    } catch (error) {
        console.error('Error initializing CodeMirror:', error);
    }
};

$(document).ready(function() {
    // Inisialisasi tombol showSolution jika sudah mencapai 10 kali percobaan
    <?php if(!empty($submission) && isset($submission['attempts']) && $submission['attempts'] >= 10 && !$submission['is_correct']): ?>
        var showSolutionBtn = document.getElementById('showSolution');
        if (showSolutionBtn) {
            showSolutionBtn.classList.remove('d-none');
            if (!showSolutionBtn.hasAttribute('data-initialized')) {
                showSolutionBtn.setAttribute('data-initialized', 'true');
                showSolutionBtn.addEventListener('click', function() {
                    if (confirm('Yakin ingin melihat solusi? Lebih baik mencoba sendiri sebisa mungkin.')) {
                        getSolution();
                    }
                });
            }
        }
    <?php endif; ?>
});
</script> 