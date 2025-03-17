<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Quiz</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Quiz Baru</h6>
            <a href="<?php echo base_url('admin/quizzes'); ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $this->session->flashdata('error'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>
            
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
            <?php echo form_open('admin/add_quiz', 'id="quiz_form"'); ?>
                <div class="form-group">
                    <label for="lesson_id">Pilih Pelajaran</label>
                    <select class="form-control" id="lesson_id" name="lesson_id" required>
                        <option value="">-- Pilih Pelajaran --</option>
                        <?php foreach ($lessons as $lesson): ?>
                            <option value="<?php echo $lesson['id']; ?>">
                                <?php echo $lesson['course_title']; ?> - <?php echo $lesson['title']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <small class="form-text text-muted">Pilih pelajaran yang akan ditambahkan quiz.</small>
                </div>
                
                <div class="form-group">
                    <label for="title">Judul Quiz</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo set_value('description'); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="passing_score">Nilai Kelulusan (%)</label>
                    <input type="number" class="form-control" id="passing_score" name="passing_score" value="<?php echo set_value('passing_score', 70); ?>" min="0" max="100" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Quiz</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> 