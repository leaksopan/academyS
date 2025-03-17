<!-- Profile Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0">My Profile</h1>
                <p class="lead">Manage your account information</p>
            </div>
            <div class="col-md-4 text-md-end">
                <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Profile Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="list-group">
                    <a href="<?= base_url('dashboard') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="<?= base_url('profile') ?>" class="list-group-item list-group-item-action active">
                        <i class="fas fa-user me-2"></i> My Profile
                    </a>
                    <a href="<?= base_url('courses') ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-book me-2"></i> Browse Courses
                    </a>
                    <a href="<?= base_url('logout') ?>" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Account Information</h4>
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('profile_updated')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('profile_updated') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($this->session->flashdata('profile_update_failed')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $this->session->flashdata('profile_update_failed') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php echo form_open('profile/update'); ?>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="created_at" class="col-sm-3 col-form-label">Member Since</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="created_at" value="<?= date('F j, Y', strtotime($user['created_at'])) ?>" readonly>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Update Profile</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="mb-0">Change Password</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row mb-3">
                                <label for="current_password" class="col-sm-3 col-form-label">Current Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="new_password" class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                    <div class="form-text">Password must be at least 6 characters long.</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <label for="confirm_password" class="col-sm-3 col-form-label">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Account Settings</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">Email Notifications</label>
                            </div>
                            <div class="form-text">Receive email notifications about course updates and new content.</div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="publicProfile" checked>
                                <label class="form-check-label" for="publicProfile">Public Profile</label>
                            </div>
                            <div class="form-text">Allow other users to see your profile and learning progress.</div>
                        </div>
                        
                        <hr>
                        
                        <div class="text-danger">
                            <h5>Danger Zone</h5>
                            <p>Once you delete your account, there is no going back. Please be certain.</p>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                Delete Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Delete Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <p>All your data, including course progress and enrollments, will be permanently deleted.</p>
                <div class="mb-3">
                    <label for="confirmDelete" class="form-label">Type "DELETE" to confirm</label>
                    <input type="text" class="form-control" id="confirmDelete" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn" disabled>Delete Account</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const confirmDeleteInput = document.getElementById('confirmDelete');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        
        confirmDeleteInput.addEventListener('input', function() {
            confirmDeleteBtn.disabled = this.value !== 'DELETE';
        });
    });
</script> 