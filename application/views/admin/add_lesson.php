<div class="container py-4">
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
    <?php if($this->session->flashdata('lesson_add_failed')): ?>
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
                    <select class="form-control <?= form_error('course_id') ? 'is-invalid' : '' ?>" id="course_id" name="course_id">
                        <option value="">Pilih Kursus</option>
                        <?php foreach ($courses as $course_item): ?>
                            <option value="<?= $course_item['id'] ?>" <?= set_value('course_id') == $course_item['id'] ? 'selected' : '' ?>>
                                <?= $course_item['title'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= form_error('course_id') ?>
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
    });
</script> 