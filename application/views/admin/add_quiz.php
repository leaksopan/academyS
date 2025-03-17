<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Quiz</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Quiz untuk Pelajaran: <?php echo $lesson['title']; ?></h6>
            <a href="<?php echo base_url('admin/quizzes?lesson_id=' . $lesson['id']); ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
            <?php echo form_open('admin/add_quiz?lesson_id=' . $lesson['id'], 'id="quiz_form"'); ?>
                <div class="form-group">
                    <label for="title">Judul Quiz</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo set_value('title', 'Quiz: ' . $lesson['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?php echo set_value('description', 'Quiz untuk pelajaran: ' . $lesson['title']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="passing_score">Nilai Kelulusan (%)</label>
                    <input type="number" class="form-control" id="passing_score" name="passing_score" value="<?php echo set_value('passing_score', 70); ?>" min="0" max="100" required>
                </div>
                
                <hr>
                <h5>Pertanyaan</h5>
                <p class="text-muted">Anda dapat menambahkan pertanyaan setelah membuat quiz.</p>
                
                <button type="submit" class="btn btn-primary">Simpan Quiz</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> 