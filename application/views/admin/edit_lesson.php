<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Edit Pelajaran</h1>
            <p class="text-muted">Edit pelajaran untuk kursus: <strong><?= $course['title'] ?></strong></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/lessons?course_id=' . $lesson['course_id']) ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pelajaran
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('lesson_update_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('lesson_update_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Edit Lesson Form -->
    <div class="card">
        <div class="card-body">
            <?= form_open('admin/edit_lesson/' . $lesson['id']) ?>
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Pelajaran</label>
                    <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= set_value('title', $lesson['title']) ?>">
                    <div class="invalid-feedback">
                        <?= form_error('title') ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="order_number" class="form-label">Urutan</label>
                    <input type="number" class="form-control <?= form_error('order_number') ? 'is-invalid' : '' ?>" id="order_number" name="order_number" value="<?= set_value('order_number', $lesson['order_number']) ?>">
                    <div class="invalid-feedback">
                        <?= form_error('order_number') ?>
                    </div>
                    <small class="text-muted">Urutan pelajaran dalam kursus (1, 2, 3, dst.)</small>
                </div>
                
                <div class="mb-3">
                    <label for="content" class="form-label">Konten Pelajaran</label>
                    <textarea class="form-control <?= form_error('content') ? 'is-invalid' : '' ?>" id="content" name="content" rows="10"><?= set_value('content', $lesson['content']) ?></textarea>
                    <div class="invalid-feedback">
                        <?= form_error('content') ?>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Perbarui Pelajaran</button>
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
    });
</script> 