<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Pertanyaan</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Pertanyaan untuk Quiz: <?php echo $quiz['title']; ?></h6>
            <a href="<?php echo base_url('admin/edit_quiz/' . $quiz['id']); ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
            <?php echo form_open('admin/edit_question/' . $question['id'], 'id="question_form"'); ?>
                <div class="form-group">
                    <label for="question_text">Pertanyaan</label>
                    <textarea class="form-control" id="question_text" name="question_text" rows="3" required><?php echo set_value('question_text', $question['question_text']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="question_type">Tipe Pertanyaan</label>
                    <input type="text" class="form-control" value="<?php echo ($question['question_type'] == 'multiple_choice') ? 'Pilihan Ganda' : 'Essay'; ?>" readonly>
                    <small class="form-text text-muted">Tipe pertanyaan tidak dapat diubah.</small>
                </div>
                
                <div class="form-group">
                    <label for="points">Poin</label>
                    <input type="number" class="form-control" id="points" name="points" value="<?php echo set_value('points', $question['points']); ?>" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="order_number">Urutan</label>
                    <input type="number" class="form-control" id="order_number" name="order_number" value="<?php echo set_value('order_number', $question['order_number']); ?>" min="1" required>
                </div>
                
                <?php if ($question['question_type'] == 'multiple_choice'): ?>
                    <div id="options_container">
                        <h5 class="mt-4">Opsi Jawaban</h5>
                        <p class="text-muted">Pilih opsi yang benar.</p>
                        
                        <?php foreach ($options as $index => $option): ?>
                            <div class="form-group">
                                <label>Opsi <?php echo $index + 1; ?></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="radio" name="correct_option" value="<?php echo $index; ?>" <?php echo ($option['is_correct'] == 1) ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="options[<?php echo $index; ?>]" value="<?php echo $option['option_text']; ?>" required>
                                    <input type="hidden" name="option_ids[<?php echo $index; ?>]" value="<?php echo $option['id']; ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Tambah opsi baru -->
                        <div class="form-group">
                            <label>Opsi Baru</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input type="radio" name="correct_option" value="new_0">
                                    </div>
                                </div>
                                <input type="text" class="form-control" name="options[new][0]" placeholder="Opsi jawaban baru (opsional)">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> 