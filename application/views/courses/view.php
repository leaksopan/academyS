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
                        <h4 class="mb-0">About This Course</h4>
                    </div>
                    <div class="card-body">
                        <p><?= $course['description'] ?></p>
                        
                        <h5 class="mt-4">What You'll Learn</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Understand the fundamentals of <?= $course['title'] ?>
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Build real-world projects to apply your knowledge
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Master best practices and industry standards
                            </li>
                            <li class="list-group-item">
                                <i class="fas fa-check-circle text-success me-2"></i> 
                                Gain practical experience through hands-on exercises
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Course Content</h4>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="lessonAccordion">
                            <?php if (empty($lessons)): ?>
                                <p>No lessons available for this course yet.</p>
                            <?php else: ?>
                                <?php foreach ($lessons as $index => $lesson): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?= $lesson['id'] ?>">
                                            <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $lesson['id'] ?>" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>" aria-controls="collapse<?= $lesson['id'] ?>">
                                                Lesson <?= $index + 1 ?>: <?= $lesson['title'] ?>
                                            </button>
                                        </h2>
                                        <div id="collapse<?= $lesson['id'] ?>" class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>" aria-labelledby="heading<?= $lesson['id'] ?>" data-bs-parent="#lessonAccordion">
                                            <div class="accordion-body">
                                                <p><?= character_limiter(strip_tags($lesson['content']), 150) ?></p>
                                                <?php if ($this->session->userdata('logged_in')): ?>
                                                    <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $lesson['id']) ?>" class="btn btn-primary btn-sm">Start Lesson</a>
                                                <?php else: ?>
                                                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-sm">Log in to access</a>
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
                                    <i class="fas fa-check-circle me-2"></i> You are enrolled in this course
                                </div>
                                <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $lessons[0]['id']) ?>" class="btn btn-primary btn-lg w-100">Continue Learning</a>
                            <?php else: ?>
                                <h4 class="mb-3">Ready to start learning?</h4>
                                <a href="<?= base_url('enroll/' . $course['id']) ?>" class="btn btn-primary btn-lg w-100">Enroll Now - It's Free!</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <h4 class="mb-3">Ready to start learning?</h4>
                            <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg w-100 mb-3">Log In to Enroll</a>
                            <p class="mb-0">Don't have an account? <a href="<?= base_url('register') ?>">Sign up</a></p>
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
        <h2 class="mb-4">Related Courses</h2>
        <div class="row">
            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="col-md-4 mb-4">
                    <div class="card course-card h-100">
                        <div class="card-img-top bg-white d-flex align-items-center justify-content-center" style="height: 160px;">
                            <i class="fas fa-code fa-3x text-muted"></i>
                        </div>
                        <div class="card-body">
                            <span class="course-level level-beginner">Beginner</span>
                            <h5 class="card-title">Related Course Title</h5>
                            <p class="card-text">This is a sample related course that you might be interested in based on your current selection.</p>
                            <a href="#" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section> 