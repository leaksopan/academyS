<!-- Dashboard Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">Dashboard saya</h1>
                <p class="lead">Selamat Datang Kembali, <?= $user['username'] ?>!</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?= base_url('profile') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-user-circle me-2"></i> Lihat Profil
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Dashboard Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="list-group">
                    <a href="<?= base_url('dashboard') ?>" class="list-group-item list-group-item-action active">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="<?= base_url('profile') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-user me-2"></i> Profile Saya
                    </a>
                    <a href="<?= base_url('courses') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i> Telusuri Kursus
                    </a>
                    <a href="<?= base_url('logout') ?>" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Pencapaian</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Kursus yang diikuti:</span>
                            <span class="badge bg-primary"><?= count($enrolled_courses) ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Kursus yang selesai:</span>
                            <span class="badge bg-success">
                                <?php
                                $completed_courses = 0;
                                foreach ($enrolled_courses as $course) {
                                    if (isset($course['progress']) && $course['progress']['percentage'] == 100) {
                                        $completed_courses++;
                                    }
                                }
                                echo $completed_courses;
                                ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Total Learning Time:</span>
                            <span class="badge bg-info">
                                <?= isset($total_learning_time) ? $total_learning_time : '0h 0m' ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Progress Quiz -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Progress Quiz</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Quiz yang Lulus:</span>
                            <span class="badge bg-success"><?php echo $quiz_model->count_passed_quizzes($user['id']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Rata-rata Skor:</span>
                            <span class="badge bg-info"><?php echo number_format($quiz_model->get_user_average_score($user['id']), 1); ?>%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- My Courses -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Kursus saya</h4>
                        <a href="<?= base_url('courses') ?>" class="btn btn-sm btn-primary">Telusuri semua kursus</a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($enrolled_courses)): ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> Kamu gak punya kursus sampai sekarang.
                                <a href="<?= base_url('courses') ?>" class="alert-link">lihat catalog kita</a> untuk memulai.
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($enrolled_courses as $course): ?>
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100">
                                            <?php if ($course['image']): ?>
                                                <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>" style="height: 140px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                                    <i class="fas fa-code fa-3x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $course['title'] ?></h5>
                                                
                                                <?php
                                                $course_progress = 0;
                                                if (isset($course['progress'])) {
                                                    $course_progress = $course['progress']['percentage'];
                                                }
                                                ?>
                                                
                                                <div class="progress mb-3" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $course_progress ?>%;" aria-valuenow="<?= $course_progress ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between mb-3">
                                                    <small class="text-muted"><?= round($course_progress) ?>% complete</small>
                                                    <small class="text-muted">
                                                        <?php
                                                        if (isset($course['progress'])) {
                                                            echo $course['progress']['completed'] . '/' . $course['progress']['total'] . ' lessons';
                                                        } else {
                                                            echo '0/0 lessons';
                                                        }
                                                        ?>
                                                    </small>
                                                </div>
                                                
                                                <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-primary btn-sm">Lanjut Belajar</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Recommended Courses -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Rekomendasi untuk Kamu</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php
                            // Get all courses
                            $all_courses = $this->course_model->get_all_courses();
                            
                            // Filter out enrolled courses
                            $enrolled_course_ids = array_map(function($course) {
                                return $course['id'];
                            }, $enrolled_courses);
                            
                            $recommended_courses = array_filter($all_courses, function($course) use ($enrolled_course_ids) {
                                return !in_array($course['id'], $enrolled_course_ids);
                            });
                            
                            // Limit to 3 courses
                            $recommended_courses = array_slice($recommended_courses, 0, 3);
                            
                            if (empty($recommended_courses)):
                            ?>
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i> You've enrolled in all available courses!
                                    </div>
                                </div>
                            <?php else: ?>
                                <?php foreach ($recommended_courses as $course): ?>
                                    <div class="col-md-4 mb-4">
                                        <div class="card h-100">
                                            <?php if ($course['image']): ?>
                                                <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>" style="height: 140px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 140px;">
                                                    <i class="fas fa-code fa-3x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="card-body">
                                                <span class="course-level level-<?= $course['level'] ?>"><?= ucfirst($course['level']) ?></span>
                                                <h5 class="card-title"><?= $course['title'] ?></h5>
                                                <p class="card-text"><?= character_limiter($course['description'], 80) ?></p>
                                                <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-outline-primary btn-sm">View Course</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>
</section> 