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
                        <div class="alert alert-info mb-4">
                            <h5 class="mb-3"><i class="fas fa-history me-2"></i> Riwayat Percobaan Quiz</h5>
                            
                            <?php 
                            // Cari nilai tertinggi
                            $highest_score = 0;
                            $highest_attempt = null;
                            foreach ($attempts as $attempt) {
                                if ($attempt['score'] > $highest_score) {
                                    $highest_score = $attempt['score'];
                                    $highest_attempt = $attempt;
                                }
                            }
                            ?>
                            
                            <?php if ($highest_attempt): ?>
                                <div class="card mb-3 border-<?= $highest_attempt['passed'] ? 'success' : 'warning' ?>">
                                    <div class="card-body py-2">
                                        <h6 class="mb-2"><i class="fas fa-trophy me-2"></i> Nilai Tertinggi Anda</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Skor:</strong> <span class="badge bg-<?= $highest_attempt['passed'] ? 'success' : 'warning' ?>"><?= number_format($highest_attempt['score'], 1) ?>%</span></p>
                                                <p class="mb-1"><strong>Status:</strong> 
                                                    <?php if($highest_attempt['passed']): ?>
                                                        <span class="badge bg-success">Lulus</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Belum Lulus</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-1"><strong>Target:</strong> <span class="badge bg-primary"><?= $quiz['passing_score'] ?>%</span></p>
                                                <p class="mb-1"><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($highest_attempt['completed_at'])) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <h6 class="mb-2"><i class="fas fa-list me-2"></i> Semua Percobaan (<?= count($attempts) ?>)</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Skor</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($attempts as $key => $attempt): ?>
                                            <tr>
                                                <td><?= count($attempts) - $key ?></td>
                                                <td><?= date('d/m/Y H:i', strtotime($attempt['completed_at'])) ?></td>
                                                <td><span class="badge bg-<?= $attempt['passed'] ? 'success' : 'warning' ?>"><?= number_format($attempt['score'], 1) ?>%</span></td>
                                                <td><?= $attempt['passed'] ? '<span class="badge bg-success">Lulus</span>' : '<span class="badge bg-danger">Belum Lulus</span>' ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
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
