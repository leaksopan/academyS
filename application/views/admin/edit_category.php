<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Edit Kategori</h1>
            <p class="text-muted">Edit kategori: <strong><?= $category['name'] ?></strong></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/categories') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kategori
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('category_update_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('category_update_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('slug_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('slug_error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Edit Category Form -->
    <div class="card">
        <div class="card-body">
            <?= form_open('admin/edit_category/' . $category['id']) ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= set_value('name', $category['name']) ?>">
                    <div class="invalid-feedback">
                        <?= form_error('name') ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= form_error('slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= set_value('slug', $category['slug']) ?>">
                    <input type="hidden" name="old_slug" value="<?= $category['slug'] ?>">
                    <div class="invalid-feedback">
                        <?= form_error('slug') ?>
                    </div>
                    <small class="text-muted">Slug digunakan untuk URL kategori. Contoh: web-development</small>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" id="description" name="description" rows="5"><?= set_value('description', $category['description']) ?></textarea>
                    <div class="invalid-feedback">
                        <?= form_error('description') ?>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Perbarui Kategori</button>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
    // Auto generate slug from name
    document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');
        const oldSlug = "<?= $category['slug'] ?>";
        
        nameInput.addEventListener('keyup', function() {
            // Hanya generate slug otomatis jika slug belum diubah manual
            if (slugInput.value === oldSlug) {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
            }
        });
    });
</script> 