<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo base_url('courses'); ?>">Kursus</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('courses/' . $course['slug']); ?>"><?php echo $course['title']; ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('courses/' . $course['slug'] . '/lesson/' . $lesson['id']); ?>"><?php echo $lesson['title']; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Quiz</li>
        </ol>
    </nav>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo $quiz['title']; ?></h4>
                    <p class="mb-0"><?php echo $quiz['description']; ?></p>
                </div>
                <div class="card-body">
                    <?php if (!empty($attempts)): ?>
                        <div class="alert alert-info">
                            <h5>Riwayat Percobaan</h5>
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($attempts as $attempt): ?>
                                    <li>
                                        Skor: <?php echo number_format($attempt['score'], 1); ?>% 
                                        (<?php echo $attempt['passed'] ? 'Lulus' : 'Tidak Lulus'; ?>)
                                        - <?php echo date('d/m/Y H:i', strtotime($attempt['completed_at'])); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form id="quiz_form" method="post" action="<?php echo site_url('submit_quiz'); ?>">
                        <input type="hidden" name="quiz_id" value="<?php echo $quiz['id']; ?>">
                        
                        <?php foreach ($questions as $index => $question): ?>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">Pertanyaan <?php echo $index + 1; ?></h5>
                                    <p class="card-text"><?php echo $question['question_text']; ?></p>
                                    <p class="text-muted">Poin: <?php echo $question['points']; ?></p>

                                    <?php if ($question['question_type'] == 'multiple_choice'): ?>
                                        <?php 
                                        $options = $this->quiz_model->get_question_options($question['id']);
                                        foreach ($options as $option): 
                                        ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                    name="answers[<?php echo $question['id']; ?>]" 
                                                    value="<?php echo $option['id']; ?>" 
                                                    id="option_<?php echo $option['id']; ?>" required>
                                                <label class="form-check-label" for="option_<?php echo $option['id']; ?>">
                                                    <?php echo $option['option_text']; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="form-group">
                                            <textarea class="form-control" 
                                                name="answers[<?php echo $question['id']; ?>]" 
                                                rows="4" required></textarea>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Quiz</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nilai Minimal Lulus:</strong> <?php echo $quiz['passing_score']; ?>%</p>
                    <p><strong>Jumlah Pertanyaan:</strong> <?php echo count($questions); ?></p>
                    <p><strong>Total Poin:</strong> <?php 
                        $total_points = 0;
                        foreach ($questions as $question) {
                            $total_points += $question['points'];
                        }
                        echo $total_points;
                    ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
