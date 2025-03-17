<!-- Lesson Header -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('courses') ?>">Courses</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('courses/' . $course['slug']) ?>"><?= $course['title'] ?></a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $lesson['title'] ?></li>
                    </ol>
                </nav>
                <h1 class="mb-0"><?= $lesson['title'] ?></h1>
            </div>
        </div>
    </div>
</section>

<!-- Lesson Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="lesson-sidebar">
                    <h5 class="mb-3">Course Content</h5>
                    <ul class="lesson-list">
                        <?php foreach ($lessons as $index => $l): ?>
                            <li class="lesson-list-item <?= $l['id'] == $lesson['id'] ? 'active' : '' ?>">
                                <div class="d-flex align-items-center">
                                    <?php if (isset($progress) && isset($progress[$l['id']]) && $progress[$l['id']]['completed']): ?>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                    <?php else: ?>
                                        <i class="far fa-circle me-2"></i>
                                    <?php endif; ?>
                                    
                                    <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $l['id']) ?>" class="<?= $l['id'] == $lesson['id'] ? 'text-white' : 'text-dark' ?> text-decoration-none flex-grow-1">
                                        Lesson <?= $index + 1 ?>: <?= $l['title'] ?>
                                    </a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="mt-4">
                        <div class="form-check">
                            <input class="form-check-input progress-check" type="checkbox" id="markComplete" 
                                   data-lesson-id="<?= $lesson['id'] ?>" 
                                   data-course-id="<?= $course['id'] ?>"
                                   <?= (isset($progress) && isset($progress[$lesson['id']]) && $progress[$lesson['id']]['completed']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="markComplete">
                                Mark as completed
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="lesson-content">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $lesson['title']; ?></h4>
                            <div class="card-text">
                                <?php echo $lesson['content']; ?>
                            </div>
                            
                            <?php if (isset($quiz)): ?>
                                <div class="mt-4">
                                    <a href="<?php echo base_url('courses/' . $course['slug'] . '/quiz/' . $lesson['id']); ?>" 
                                       class="btn btn-primary">
                                        <i class="fas fa-question-circle"></i> Mulai Quiz
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex justify-content-between">
                        <?php
                        $prev_lesson = null;
                        $next_lesson = null;
                        
                        foreach ($lessons as $index => $l) {
                            if ($l['id'] == $lesson['id']) {
                                if ($index > 0) {
                                    $prev_lesson = $lessons[$index - 1];
                                }
                                if ($index < count($lessons) - 1) {
                                    $next_lesson = $lessons[$index + 1];
                                }
                                break;
                            }
                        }
                        ?>
                        
                        <?php if ($prev_lesson): ?>
                            <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $prev_lesson['id']) ?>" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> Previous Lesson
                            </a>
                        <?php else: ?>
                            <div></div>
                        <?php endif; ?>
                        
                        <?php if ($next_lesson): ?>
                            <a href="<?= base_url('courses/' . $course['slug'] . '/lesson/' . $next_lesson['id']) ?>" class="btn btn-primary">
                                Next Lesson <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-success">
                                <i class="fas fa-check-circle me-2"></i> Complete Course
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Comments Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Discussion</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <label for="comment" class="form-label">Leave a comment or question</label>
                                <textarea class="form-control" id="comment" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Post Comment</button>
                        </form>
                        
                        <hr class="my-4">
                        
                        <div class="comments">
                            <div class="comment mb-4">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="https://via.placeholder.com/50" class="rounded-circle" alt="User">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mt-0">John Doe</h5>
                                        <p class="text-muted small">Posted 3 days ago</p>
                                        <p>This lesson was really helpful! I especially liked the examples provided.</p>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="far fa-thumbs-up me-1"></i> Like
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="far fa-comment me-1"></i> Reply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="comment">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <img src="https://via.placeholder.com/50" class="rounded-circle" alt="User">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mt-0">Jane Smith</h5>
                                        <p class="text-muted small">Posted 1 week ago</p>
                                        <p>I'm having trouble understanding the concept in the third paragraph. Could someone explain it in simpler terms?</p>
                                        <div>
                                            <button class="btn btn-sm btn-outline-primary me-2">
                                                <i class="far fa-thumbs-up me-1"></i> Like
                                            </button>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                <i class="far fa-comment me-1"></i> Reply
                                            </button>
                                        </div>
                                        
                                        <!-- Nested comment -->
                                        <div class="comment mt-3">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="https://via.placeholder.com/50" class="rounded-circle" alt="User">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="mt-0">Instructor</h5>
                                                    <p class="text-muted small">Posted 6 days ago</p>
                                                    <p>Hi Jane, the concept is about [explanation]. Hope this helps!</p>
                                                    <div>
                                                        <button class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="far fa-thumbs-up me-1"></i> Like
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-secondary">
                                                            <i class="far fa-comment me-1"></i> Reply
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Script untuk menangani update progress -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const progressCheck = document.querySelector('.progress-check');
    
    if (progressCheck) {
        progressCheck.addEventListener('change', function() {
            const lessonId = this.dataset.lessonId;
            const courseId = this.dataset.courseId;
            const completed = this.checked ? 1 : 0;
            
            // Kirim AJAX request untuk update progress
            fetch('<?= base_url('dashboard/update_progress') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `lesson_id=${lessonId}&course_id=${courseId}&completed=${completed}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Progress updated successfully');
                } else {
                    console.error('Failed to update progress');
                    // Kembalikan checkbox ke status sebelumnya jika gagal
                    this.checked = !this.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Kembalikan checkbox ke status sebelumnya jika terjadi error
                this.checked = !this.checked;
            });
        });
    }
});
</script> 