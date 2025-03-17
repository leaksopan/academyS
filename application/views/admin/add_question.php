<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Pertanyaan</h1>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Pertanyaan untuk Quiz: <?php echo $quiz['title']; ?></h6>
            <a href="<?php echo base_url('admin/edit_quiz/' . $quiz['id']); ?>" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            
            <?php echo form_open('admin/add_question/' . $quiz['id'], 'id="question_form"'); ?>
                <div class="form-group">
                    <label for="question_text">Pertanyaan</label>
                    <textarea class="form-control" id="question_text" name="question_text" rows="3" required><?php echo set_value('question_text'); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="question_type">Tipe Pertanyaan</label>
                    <select class="form-control" id="question_type" name="question_type" required>
                        <option value="multiple_choice" <?php echo set_select('question_type', 'multiple_choice', true); ?>>Pilihan Ganda</option>
                        <option value="essay" <?php echo set_select('question_type', 'essay'); ?>>Essay</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="points">Poin</label>
                    <input type="number" class="form-control" id="points" name="points" value="<?php echo set_value('points', 10); ?>" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="order_number">Urutan</label>
                    <input type="number" class="form-control" id="order_number" name="order_number" value="<?php echo set_value('order_number', 1); ?>" min="1" required>
                </div>
                
                <div id="options_container">
                    <h5 class="mt-4">Opsi Jawaban</h5>
                    <p class="text-muted">Untuk pertanyaan pilihan ganda, tambahkan opsi jawaban dan pilih opsi yang benar.</p>
                    
                    <div class="form-group">
                        <label>Opsi 1</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="0" checked>
                                </div>
                            </div>
                            <input type="text" class="form-control" name="options[0]" placeholder="Opsi jawaban 1" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Opsi 2</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="1">
                                </div>
                            </div>
                            <input type="text" class="form-control" name="options[1]" placeholder="Opsi jawaban 2" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Opsi 3</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="2">
                                </div>
                            </div>
                            <input type="text" class="form-control" name="options[2]" placeholder="Opsi jawaban 3" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Opsi 4</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="correct_option" value="3">
                                </div>
                            </div>
                            <input type="text" class="form-control" name="options[3]" placeholder="Opsi jawaban 4">
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Pertanyaan</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionType = document.getElementById('question_type');
    const optionsContainer = document.getElementById('options_container');
    
    // Tampilkan/sembunyikan opsi berdasarkan tipe pertanyaan
    function toggleOptions() {
        if (questionType.value === 'multiple_choice') {
            optionsContainer.style.display = 'block';
        } else {
            optionsContainer.style.display = 'none';
        }
    }
    
    // Panggil fungsi saat halaman dimuat
    toggleOptions();
    
    // Tambahkan event listener untuk perubahan tipe pertanyaan
    questionType.addEventListener('change', toggleOptions);
});
</script> 