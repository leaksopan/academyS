<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Log In</h2>
                        
                        <?php if($this->session->flashdata('login_failed')): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('login_failed'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($this->session->flashdata('user_registered')): ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('user_registered'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($this->session->flashdata('user_logged_out')): ?>
                            <div class="alert alert-info">
                                <?php echo $this->session->flashdata('user_logged_out'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($this->session->flashdata('password_reset')): ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('password_reset'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php echo form_open('auth/login'); ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control <?php echo form_error('password') ? 'is-invalid' : ''; ?>" id="password" name="password" required>
                                <div class="invalid-feedback">
                                    <?php echo form_error('password'); ?>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Log In</button>
                            </div>
                        <?php echo form_close(); ?>
                        
                        <div class="text-center mt-4">
                            <p>Don't have an account? <a href="<?php echo base_url('auth/register'); ?>">Sign up</a></p>
                            <p><a href="<?php echo base_url('auth/reset_password'); ?>">Forgot password?</a></p>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Demo Accounts</h5>
                        <p class="card-text">Use these credentials to test the application:</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Email: admin@academys.com<br>Password: password</li>
                            <li class="list-group-item">Email: user1@example.com<br>Password: password</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>