<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Quiz</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Quiz untuk Pelajaran: <?php echo $lesson['title']; ?></h6>
            <a href="<?php echo base_url('admin/quizzes?lesson_id=' . $lesson['id']); ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
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
            
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
            <?php echo form_open('admin/edit_quiz/' . $quiz['id'], 'id="quiz_form"'); ?>
                <div class="form-group">
                    <label for="title">Judul Quiz</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', $quiz['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo set_value('description', $quiz['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="passing_score">Nilai Kelulusan (%)</label>
                    <input type="number" class="form-control" id="passing_score" name="passing_score" value="<?php echo set_value('passing_score', $quiz['passing_score']); ?>" min="0" max="100" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <?php echo form_close(); ?>
            
            <hr>
            <h5 class="mt-4">Pertanyaan</h5>
            <div class="mb-3">
                <a href="<?php echo base_url('admin/add_question/' . $quiz['id']); ?>" class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Tambah Pertanyaan
                </a>
            </div>
            
            <?php if (empty($questions)): ?>
                <div class="alert alert-info">
                    Belum ada pertanyaan untuk quiz ini. Silakan tambahkan pertanyaan baru.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Pertanyaan</th>
                                <th width="15%">Tipe</th>
                                <th width="10%">Poin</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $index => $question): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo $question['question_text']; ?></td>
                                    <td>
                                        <?php if ($question['question_type'] == 'multiple_choice'): ?>
                                            <span class="badge badge-primary">Pilihan Ganda</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Essay</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $question['points']; ?></td>
                                    <td>
                                        <a href="<?php echo base_url('admin/edit_question/' . $question['id']); ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_question/' . $question['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 