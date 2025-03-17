<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Kelola Pengguna</h1>
            <p class="text-muted">Kelola semua pengguna di platform AcademyS.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <a href="<?= base_url('admin/add_user') ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Tambah Pengguna
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('user_added')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('user_added') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('user_updated')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('user_updated') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('user_deleted')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('user_deleted') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($users)): ?>
                            <?php foreach($users as $user): ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['full_name'] ?? '-' ?></td>
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
                                        <a href="<?= base_url('admin/edit_user/' . $user['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if($user['id'] != $this->session->userdata('user_id')): ?>
                                            <a href="<?= base_url('admin/delete_user/' . $user['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pengguna</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 