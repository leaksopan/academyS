<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-3">Edit Pengguna</h1>
            <p class="text-muted">Edit data pengguna: <strong><?= $user['username'] ?></strong></p>
        </div>
        <div class="col-md-4 text-end">
            <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pengguna
            </a>
        </div>
    </div>
    
    <!-- Flash Messages -->
    <?php if($this->session->flashdata('user_update_failed')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('user_update_failed') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('upload_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $this->session->flashdata('upload_error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <!-- Edit User Form -->
    <div class="card">
        <div class="card-body">
            <?= form_open_multipart('admin/edit_user/' . $user['id']); ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" id="username" name="username" value="<?= set_value('username', $user['username']) ?>">
                        <div class="invalid-feedback">
                            <?= form_error('username') ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= set_value('email', $user['email']) ?>">
                        <div class="invalid-feedback">
                            <?= form_error('email') ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" id="password" name="password">
                        <div class="invalid-feedback">
                            <?= form_error('password') ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control <?= form_error('confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password">
                        <div class="invalid-feedback">
                            <?= form_error('confirm_password') ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="profile_image" class="form-label">Foto Profil</label>
                    <?php if(isset($user['profile_image']) && $user['profile_image']): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('assets/images/profiles/' . $user['profile_image']) ?>" alt="<?= $user['username'] ?>" width="100" class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                    <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Ukuran maksimal: 2MB. Kosongkan jika tidak ingin mengubah.</small>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select <?= form_error('role') ? 'is-invalid' : '' ?>" id="role" name="role">
                            <option value="">Pilih Role</option>
                            <option value="user" <?= set_value('role', $user['role']) == 'user' ? 'selected' : '' ?>>User</option>
                            <option value="admin" <?= set_value('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <div class="invalid-feedback">
                            <?= form_error('role') ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?= set_value('is_active', $user['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <?= form_close() ?>
        </div>
    </div>
</div> 