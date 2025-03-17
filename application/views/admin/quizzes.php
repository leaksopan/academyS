<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Kelola Quiz</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Quiz untuk Pelajaran: <?php echo $lesson['title']; ?></h6>
            <div>
                <a href="<?php echo base_url('admin/lessons?course_id=' . $course['id']); ?>" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pelajaran
                </a>
                <?php if (empty($quiz)): ?>
                <a href="<?php echo base_url('admin/add_quiz?lesson_id=' . $lesson['id']); ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Tambah Quiz
                </a>
                <?php endif; ?>
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
                <?php if (!empty($quiz)): ?>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th>Nilai Kelulusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $quiz['title']; ?></td>
                                <td><?php echo $quiz['description']; ?></td>
                                <td><?php echo $quiz['passing_score']; ?>%</td>
                                <td>
                                    <a href="<?php echo base_url('admin/edit_quiz/' . $quiz['id']); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?php echo base_url('admin/delete_quiz/' . $quiz['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus quiz ini?');">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        Belum ada quiz untuk pelajaran ini. Silakan tambahkan quiz baru.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 