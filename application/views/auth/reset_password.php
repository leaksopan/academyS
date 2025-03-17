<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Reset Password</h2>
                        
                        <?php if($this->session->flashdata('reset_failed')): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('reset_failed'); ?>
                            </div>
                        <?php endif; ?>
                        
                        <p class="text-center mb-4">Enter your email address and we'll send you instructions to reset your password.</p>
                        
                        <?php echo form_open('auth/reset_password'); ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?php echo form_error('email') ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                            </div>
                        <?php echo form_close(); ?>
                        
                        <div class="text-center mt-4">
                            <p>Remember your password? <a href="<?php echo base_url('auth/login'); ?>">Back to login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 