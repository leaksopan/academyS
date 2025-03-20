<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Kelola Coding Exercises</h1>
            <p class="text-muted">Kelola latihan coding interaktif untuk pembelajaran.</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <a href="<?= base_url('admin/add_coding_exercise') ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> Tambah Exercise
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Exercises Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Pelajaran</th>
                            <th>Bahasa</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($exercises)): ?>
                            <?php foreach($exercises as $exercise): ?>
                                <tr>
                                    <td><?= $exercise['id'] ?></td>
                                    <td><?= $exercise['title'] ?></td>
                                    <td><?= $exercise['lesson_title'] ?></td>
                                    <td>
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
                                    </td>
                                    <td><?= date('d M Y', strtotime($exercise['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('coding/exercise/' . $exercise['id']) ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/edit_coding_exercise/' . $exercise['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/delete_coding_exercise/' . $exercise['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus exercise ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data coding exercise</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 