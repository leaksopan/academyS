<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Semua Quiz</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Semua Quiz</h6>
            <div>
                <a href="<?php echo base_url('admin/add_quiz'); ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Quiz
                </a>
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <div class="table-responsive">
                <?php if (!empty($quizzes)): ?>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Judul Quiz</th>
                                <th>Pelajaran</th>
                                <th>Kursus</th>
                                <th>Nilai Kelulusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($quizzes as $quiz): ?>
                                <tr>
                                    <td><?php echo $quiz['id']; ?></td>
                                    <td><?php echo $quiz['title']; ?></td>
                                    <td><?php echo $quiz['lesson_title']; ?></td>
                                    <td><?php echo $quiz['course_title']; ?></td>
                                    <td><?php echo $quiz['passing_score']; ?>%</td>
                                    <td>
                                        <a href="<?php echo base_url('admin/edit_quiz/' . $quiz['id']); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo base_url('courses/' . $quiz['course_slug'] . '/quiz/' . $quiz['lesson_id']); ?>" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_quiz/' . $quiz['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus quiz ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        Belum ada quiz yang ditambahkan. Silakan tambahkan quiz baru melalui halaman pelajaran.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 