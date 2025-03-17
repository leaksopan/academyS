<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Edit Kursus</h1>
            <p class="text-muted">Edit kursus "<?= $course['title'] ?>".</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Kursus
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('course_update_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('course_update_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('upload_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('upload_error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Edit Course Form -->
    <div class="card">
        <div class="card-body">
            <?= form_open_multipart('admin/courses/edit/' . $course['id']); ?>
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Kursus <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= form_error('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= set_value('title', $course['title']) ?>" required>
                            <div class="invalid-feedback">
                                <?= form_error('title') ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" value="<?= $course['slug'] ?>" disabled>
                            <div class="form-text">Slug tidak dapat diubah setelah kursus dibuat.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= form_error('description') ? 'is-invalid' : '' ?>" id="description" name="description" rows="5" required><?= set_value('description', $course['description']) ?></textarea>
                            <div class="invalid-feedback">
                                <?= form_error('description') ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select <?= form_error('category_id') ? 'is-invalid' : '' ?>" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= set_value('category_id', $course['category_id']) == $category['id'] ? 'selected' : '' ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= form_error('category_id') ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="level" class="form-label">Level</label>
                            <select class="form-select" id="level" name="level">
                                <option value="beginner" <?= set_value('level', $course['level']) == 'beginner' ? 'selected' : '' ?>>Pemula</option>
                                <option value="intermediate" <?= set_value('level', $course['level']) == 'intermediate' ? 'selected' : '' ?>>Menengah</option>
                                <option value="advanced" <?= set_value('level', $course['level']) == 'advanced' ? 'selected' : '' ?>>Lanjutan</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Kursus</label>
                            <?php if($course['image']): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" alt="<?= $course['title'] ?>" class="img-thumbnail" style="max-width: 100%; max-height: 150px;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah gambar. Format yang didukung: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB.</div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" <?= set_value('is_featured', $course['is_featured']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_featured">Tampilkan di Halaman Utama</label>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary me-md-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            <?= form_close(); ?>
        </div>
    </div>
</div> 