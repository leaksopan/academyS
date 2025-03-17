<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Kelola Kursus</h1>
            <p class="text-muted">Kelola semua kursus di platform AcademyS.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <a href="<?= base_url('admin/courses/add') ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Tambah Kursus
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('course_added')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('course_added') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('course_updated')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('course_updated') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('course_deleted')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('course_deleted') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Filter by Category -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?= base_url('admin/courses') ?>" method="get" class="row g-3">
                <div class="col-md-4">
                    <label for="category" class="form-label">Filter berdasarkan Kategori</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php foreach($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= isset($_GET['category']) && $_GET['category'] == $category['id'] ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="level" class="form-label">Filter berdasarkan Level</label>
                    <select name="level" id="level" class="form-select">
                        <option value="">Semua Level</option>
                        <option value="beginner" <?= isset($_GET['level']) && $_GET['level'] == 'beginner' ? 'selected' : '' ?>>Pemula</option>
                        <option value="intermediate" <?= isset($_GET['level']) && $_GET['level'] == 'intermediate' ? 'selected' : '' ?>>Menengah</option>
                        <option value="advanced" <?= isset($_GET['level']) && $_GET['level'] == 'advanced' ? 'selected' : '' ?>>Lanjutan</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Courses Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Level</th>
                            <th>Featured</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($courses)): ?>
                            <?php foreach($courses as $course): ?>
                                <tr>
                                    <td><?= $course['id'] ?></td>
                                    <td>
                                        <?php if($course['image']): ?>
                                            <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" alt="<?= $course['title'] ?>" width="50" height="50" class="img-thumbnail">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $course['title'] ?></td>
                                    <td>
                                        <?php 
                                            $category_name = '';
                                            foreach($categories as $category) {
                                                if($category['id'] == $course['category_id']) {
                                                    $category_name = $category['name'];
                                                    break;
                                                }
                                            }
                                            echo $category_name;
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $course['level'] === 'beginner' ? 'bg-success' : ($course['level'] === 'intermediate' ? 'bg-warning' : 'bg-danger') ?>">
                                            <?= ucfirst($course['level']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $course['is_featured'] ? 'bg-primary' : 'bg-secondary' ?>">
                                            <?= $course['is_featured'] ? 'Ya' : 'Tidak' ?>
                                        </span>
                                    </td>
                                    <td><?= date('d M Y', strtotime($course['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/lessons?course_id=' . $course['id']) ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-list"></i>
                                        </a>
                                        <a href="<?= base_url('admin/courses/edit/' . $course['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/courses/delete/' . $course['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data kursus</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 