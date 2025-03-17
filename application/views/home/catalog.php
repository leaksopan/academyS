<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Katalog Kursus</h1>
                <p class="lead">Lihat semua kursus kami dan mulai belajar hari ini</p>
            </div>
        </div>
    </div>
</section>

<!-- Courses Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Categories</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($categories as $category): ?>
                                <li class="list-group-item">
                                    <a href="<?= base_url('courses/category/' . $category['slug']) ?>" class="text-decoration-none">
                                        <?= $category['name'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Skill Level</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-level" type="checkbox" value="beginner" id="levelBeginner">
                            <label class="form-check-label" for="levelBeginner">
                                Beginner
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input filter-level" type="checkbox" value="intermediate" id="levelIntermediate">
                            <label class="form-check-label" for="levelIntermediate">
                                Intermediate
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input filter-level" type="checkbox" value="advanced" id="levelAdvanced">
                            <label class="form-check-label" for="levelAdvanced">
                                Advanced
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Course List -->
            <div class="col-lg-9">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchCourses" placeholder="Search courses...">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="sortCourses">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="az">A-Z</option>
                            <option value="za">Z-A</option>
                        </select>
                    </div>
                </div>
                
                <div class="row" id="courseList">
                    <?php if (empty($courses)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                No courses found. Please check back later.
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <div class="col-md-6 col-lg-4 mb-4 course-item" data-level="<?= $course['level'] ?>">
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
        </div>
    </div>
</section>

<!-- JavaScript for filtering and sorting -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter by level
        const levelFilters = document.querySelectorAll('.filter-level');
        levelFilters.forEach(filter => {
            filter.addEventListener('change', filterCourses);
        });
        
        // Search functionality
        const searchInput = document.getElementById('searchCourses');
        searchInput.addEventListener('keyup', filterCourses);
        
        // Sort functionality
        const sortSelect = document.getElementById('sortCourses');
        sortSelect.addEventListener('change', sortCourses);
        
        function filterCourses() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedLevels = Array.from(levelFilters)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);
            
            const courseItems = document.querySelectorAll('.course-item');
            
            courseItems.forEach(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                const description = item.querySelector('.card-text').textContent.toLowerCase();
                const level = item.dataset.level;
                
                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesLevel = selectedLevels.length === 0 || selectedLevels.includes(level);
                
                if (matchesSearch && matchesLevel) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        function sortCourses() {
            const courseList = document.getElementById('courseList');
            const courseItems = Array.from(document.querySelectorAll('.course-item'));
            
            courseItems.sort((a, b) => {
                const titleA = a.querySelector('.card-title').textContent;
                const titleB = b.querySelector('.card-title').textContent;
                
                switch (sortSelect.value) {
                    case 'az':
                        return titleA.localeCompare(titleB);
                    case 'za':
                        return titleB.localeCompare(titleA);
                    // For newest and oldest, we would need additional data attributes
                    // This is a simplified version
                    default:
                        return 0;
                }
            });
            
            courseItems.forEach(item => courseList.appendChild(item));
        }
    });
</script> 