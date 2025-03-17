<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-3">Admin Dashboard</h1>
            <p class="text-muted">Selamat datang di panel admin AcademyS. Kelola pengguna, kursus, dan konten dari sini.</p>
            
            <?php if($this->session->flashdata('access_denied')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('access_denied') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Pengguna</h5>
                            <h2 class="mb-0"><?= $total_users ?></h2>
                        </div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= base_url('admin/users') ?>" class="text-white">Lihat Detail</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Kursus</h5>
                            <h2 class="mb-0"><?= $total_courses ?></h2>
                        </div>
                        <i class="fas fa-book fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= base_url('admin/courses') ?>" class="text-white">Lihat Detail</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Pelajaran</h5>
                            <h2 class="mb-0"><?= $total_lessons ?></h2>
                        </div>
                        <i class="fas fa-file-alt fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a href="<?= base_url('admin/lessons') ?>" class="text-white">Lihat Detail</a>
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/courses/add') ?>" class="btn btn-primary btn-lg d-block">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Kursus
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/lessons/add') ?>" class="btn btn-success btn-lg d-block">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Pelajaran
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/categories/add') ?>" class="btn btn-info btn-lg d-block">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Kategori
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary btn-lg d-block">
                                <i class="fas fa-user-cog me-2"></i> Kelola Pengguna
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/quizzes') ?>" class="btn btn-warning btn-lg d-block">
                                <i class="fas fa-question-circle me-2"></i> Kelola Quiz
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="<?= base_url('admin/add_quiz') ?>" class="btn btn-danger btn-lg d-block">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Quiz
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Users -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Pengguna Terbaru</h5>
                    <a href="<?= base_url('admin/users') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($recent_users)): ?>
                                    <?php foreach($recent_users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= $user['username'] ?></td>
                                            <td><?= $user['email'] ?></td>
                                            <td>
                                                <span class="badge <?= $user['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?>">
                                                    <?= ucfirst($user['role']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                                    <?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                                </span>
                                            </td>
                                            <td><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                            <td>
                                                <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pengguna</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 