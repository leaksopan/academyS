<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Kelola Pelajaran</h1>
            <p class="text-muted">Kelola pelajaran untuk kursus: <strong><?= $course['title'] ?></strong></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/add_lesson?course_id=' . $course_id) ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Tambah Pelajaran
            </a>
            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Kursus
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('lesson_added')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('lesson_added') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('lesson_updated')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('lesson_updated') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('lesson_deleted')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('lesson_deleted') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Lessons Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Urutan</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($lessons)): ?>
                            <?php foreach($lessons as $lesson): ?>
                                <tr>
                                    <td><?= $lesson['id'] ?></td>
                                    <td><?= $lesson['title'] ?></td>
                                    <td><?= $lesson['order_number'] ?></td>
                                    <td><?= date('d M Y', strtotime($lesson['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $lesson['id']) ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="<?= base_url('admin/edit_lesson/' . $lesson['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/delete_lesson/' . $lesson['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pelajaran ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data pelajaran</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 