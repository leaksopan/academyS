<!-- Category Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= $category['name'] ?> Courses</h1>
                <p class="lead"><?= $category['description'] ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="mb-0">Available Courses</h2>
                <p class="text-muted">Showing <?= count($courses) ?> courses in this category</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="<?= base_url('courses') ?>" class="btn btn-outline-primary">View All Categories</a>
            </div>
        </div>
        
        <div class="row">
            <?php if (empty($courses)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        No courses available in this category yet. Please check back later.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card course-card h-100">
                            <?php if ($course['image']): ?>
                                <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 160px;">
                                    <i class="fas fa-code fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <span class="course-level level-<?= $course['level'] ?>"><?= ucfirst($course['level']) ?></span>
                                <h5 class="card-title"><?= $course['title'] ?></h5>
                                <p class="card-text"><?= character_limiter($course['description'], 100) ?></p>
                                <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-primary mt-auto">View Course</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Other Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2>Explore Other Categories</h2>
                <p class="text-muted">Discover more learning opportunities in different fields</p>
            </div>
        </div>
        
        <div class="row">
            <?php 
            $other_categories = array_filter($this->course_model->get_categories(), function($cat) use ($category) {
                return $cat['id'] != $category['id'];
            });
            
            $other_categories = array_slice($other_categories, 0, 3);
            
            foreach ($other_categories as $cat): 
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= $cat['name'] ?></h5>
                            <p class="card-text"><?= character_limiter($cat['description'], 100) ?></p>
                            <a href="<?= base_url('courses/category/' . $cat['slug']) ?>" class="btn btn-outline-primary">Browse Courses</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2>Ready to start learning <?= $category['name'] ?>?</h2>
                <p class="lead mb-0">Join thousands of students already learning on our platform.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <?php if (!$this->session->userdata('logged_in')): ?>
                    <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg">Sign Up for Free</a>
                <?php else: ?>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-primary btn-lg">Go to Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>