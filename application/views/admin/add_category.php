<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Tambah Kategori</h1>
            <p class="text-muted">Tambahkan kategori baru untuk kursus di platform AcademyS.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kategori
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('category_add_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('category_add_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Add Category Form -->
    <div class="card">
        <div class="card-body">
            <?= form_open('admin/add_category') ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= set_value('name') ?>">
                    <div class="invalid-feedback">
                        <?= form_error('name') ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= form_error('slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= set_value('slug') ?>">
                    <div class="invalid-feedback">
                        <?= form_error('slug') ?>
                    </div>
                    <small class="text-muted">Slug digunakan untuk URL kategori. Contoh: web-development</small>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" id="description" name="description" rows="5"><?= set_value('description') ?></textarea>
                    <div class="invalid-feedback">
                        <?= form_error('description') ?>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    // Auto generate slug from name
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        
        nameInput.addEventListener('keyup', function() {
            slugInput.value = nameInput.value
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        });
    });
</script> 