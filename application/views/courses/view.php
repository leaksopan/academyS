<!-- Course Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <span class="course-level level-<?= $course['level'] ?> mb-2"><?= ucfirst($course['level']) ?></span>
                <h1 class="mb-3"><?= $course['title'] ?></h1>
                <p class="lead"><?= $course['description'] ?></p>
            </div>
            <div class="col-lg-4">
                <?php if ($course['image']): ?>
                    <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" class="img-fluid rounded" alt="<?= $course['title'] ?>">
                <?php else: ?>
                    <div class="bg-white rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                        <i class="fas fa-code fa-5x text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Course Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Tentang Kursus Ini</h4>
                    </div>
                    <div class="card-body">
                        <p><?= $course['description'] ?></p>
                        
                        <h5 class="mt-4">Apa yang Akan Kamu Pelajari</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Memahami dasar-dasar <?= $course['title'] ?>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Membangun proyek dunia nyata untuk menerapkan pengetahuan Anda
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Menguasai praktik terbaik dan standar industri
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Mendapatkan pengalaman praktis melalui latihan langsung
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Konten Kursus</h4>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="lessonAccordion">
                            <?php if (empty($lessons)): ?>
                                <p>Belum ada pelajaran tersedia untuk kursus ini.</p>
                            <?php else: ?>
                                <?php foreach ($lessons as $index => $lesson): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?= $lesson['id'] ?>">
                                            <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $lesson['id'] ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $lesson['id'] ?>">
                                                Pelajaran <?= $index + 1 ?>: <?= $lesson['title'] ?>
                                            </button>
                                        </h2>
                                        <div id="collapse<?= $lesson['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $lesson['id'] ?>" data-bs-parent="#lessonAccordion">
                                            <div class="accordion-body">
                                                <p><?= character_limiter(strip_tags($lesson['content']), 150) ?></p>
                                                <?php if ($this->session->userdata('logged_in')): ?>
                                                    <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $lesson['id']) ?>" class="btn btn-primary btn-sm">Mulai Pelajaran</a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-sm">Masuk untuk mengakses</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <?php if ($this->session->userdata('logged_in')): ?>
                            <?php if (isset($is_enrolled) && $is_enrolled): ?>
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i> Anda terdaftar dalam kursus ini
                                </div>
                                <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $lessons[0]['id']) ?>" class="btn btn-primary btn-lg w-100">Lanjutkan Belajar</a>
                            <?php else: ?>
                                <h4 class="mb-3">Siap untuk mulai belajar?</h4>
                                <a href="<?= base_url('enroll/' . $course['id']) ?>" class="btn btn-primary btn-lg w-100">Daftar Sekarang - Gratis!</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <h4 class="mb-3">Siap untuk mulai belajar?</h4>
                            <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg w-100 mb-3">Masuk untuk Mendaftar</a>
                            <p class="mb-0">Belum punya akun? <a href="<?= base_url('register') ?>">Daftar</a></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Course Details</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-signal me-2"></i> Level</span>
                            <span class="badge bg-primary"><?= ucfirst($course['level']) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-book me-2"></i> Lessons</span>
                            <span class="badge bg-primary"><?= count($lessons) ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-users me-2"></i> Students</span>
                            <span class="badge bg-primary">
                                <?= isset($enrolled_count) ? $enrolled_count : rand(50, 500) ?>
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-calendar-alt me-2"></i> Last Updated</span>
                            <span><?= date('M d, Y', strtotime($course['created_at'])) ?></span>
                        </li>
                    </ul>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Share This Course</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-around">
                            <a href="#" class="text-primary"><i class="fab fa-facebook-f fa-2x"></i></a>
                            <a href="#" class="text-info"><i class="fab fa-twitter fa-2x"></i></a>
                            <a href="#" class="text-danger"><i class="fab fa-pinterest fa-2x"></i></a>
                            <a href="#" class="text-success"><i class="fab fa-whatsapp fa-2x"></i></a>
                            <a href="#" class="text-secondary"><i class="fas fa-envelope fa-2x"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Courses -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="mb-4">Kursus Terkait</h2>
        <div class="row">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="col-md-4 mb-4">
                    <div class="card course-card h-100">
                        <div class="card-img-top bg-white d-flex align-items-center justify-content-center" style="height: 160px;">
                            <i class="fas fa-code fa-3x text-muted"></i>
                        </div>
                        <div class="card-body">
                            <span class="course-level level-beginner">Pemula</span>
                            <h5 class="card-title">Judul Kursus Terkait</h5>
                            <p class="card-text">Ini adalah contoh kursus terkait yang mungkin Anda minati berdasarkan pilihan Anda saat ini.</p>
                            <a href="#" class="btn btn-primary">Lihat Kursus</a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section> 