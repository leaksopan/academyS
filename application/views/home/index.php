<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Mari belajar apa yang ada di S</h1>
                <p class="lead mb-4">Belajar dari Bassic hingga penerapan ke industri langsung dengan mentor yang berpengalaman</p>
                <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg">Get Started</a>
            </div>
            <div class="col-lg-6">
                <img src="<?= base_url('assets/images/hero-illustration.svg') ?>" alt="Coding Illustration" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="mb-0">Kursus Populer</h2>
                <p class="text-muted">Ayo lihat apa yang harus kamu pelajari</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?= base_url('courses') ?>" class="btn btn-outline-primary">Lihat semua kursus</a>
            </div>
        </div>
        
        <div class="row">   
            <?php foreach ($featured_courses as $course): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card course-card">
                        <?php if ($course['image']): ?>
                            <img src="<?= base_url('assets/images/courses/' . $course['image']) ?>" class="card-img-top" alt="<?= $course['title'] ?>">
                        <?php else: ?>
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-code fa-3x text-muted"></i>
                            </div>
                        <?php endif; ?>
                        <div class="card-body">
                            <span class="course-level level-<?= $course['level'] ?>"><?= ucfirst($course['level']) ?></span>
                            <h5 class="card-title"><?= $course['title'] ?></h5>
                            <p class="card-text"><?= character_limiter($course['description'], 100) ?></p>
                            <a href="<?= base_url('courses/' . $course['slug']) ?>" class="btn btn-primary">View Course</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-0">Browse by Category</h2>
                <p class="text-muted">Find the perfect course by browsing our categories</p>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($categories as $category): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= $category['name'] ?></h5>
                            <p class="card-text"><?= character_limiter($category['description'], 100) ?></p>
                            <a href="<?= base_url('courses/category/' . $category['slug']) ?>" class="btn btn-outline-primary">Browse Courses</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2>Kenapa Magang Bersama AcademyS?</h2>
                <p class="text-muted">Belajar dari dasar hingga penerapan ke industri langsung dengan mentor yang berpengalaman</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-laptop-code fa-3x mb-3 text-primary"></i>
                    <h4>Interactive Learning</h4>
                    <p>Belajar dengan praktik langsung dan proyek dari industri.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-certificate fa-3x mb-3 text-primary"></i>
                    <h4>Earn Certificates</h4>
                    <p>perlihatkan hasil belajarmu dengan sertifikat.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="text-center">
                    <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                    <h4>Join Community</h4>
                    <p>Berkolaborasi dengan mentor dan teman-teman kerja.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 mb-3 mb-md-0">
                <h2 class="mb-0">Ready to start learning?</h2>
                <p class="lead mb-0">Join millions of learners and start coding today.</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg">Sign Up for Free</a>
            </div>
        </div>
    </div>
</section> 