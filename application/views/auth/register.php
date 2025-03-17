<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Create an Account</h2>
                        
                        <?php echo form_open('auth/register'); ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control <?php echo form_error('username') ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?php echo set_value('username'); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo form_error('username'); ?>
                                </div>
                            </div>
                            
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
                                <div class="form-text">Password must be at least 6 characters long.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control <?php echo form_error('password_confirm') ? 'is-invalid' : ''; ?>" id="password_confirm" name="password_confirm" required>
                                <div class="invalid-feedback">
                                    <?php echo form_error('password_confirm'); ?>
                                </div>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            </div>
                        <?php echo form_close(); ?>
                        
                        <div class="text-center mt-4">
                            <p>Already have an account? <a href="<?php echo base_url('login'); ?>">Log in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 