<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit User</h4>
        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    </div>
    <div class="card">
        <div class="card-body">
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
            <?php echo form_open('admin/users/edit/' . $user->id); ?>
                <div class="row">
                    <div class="col-md-6"><div class="mb-3"><label>Username *</label><input type="text" class="form-control" name="username" value="<?php echo set_value('username', $user->username); ?>" required></div></div>
                    <div class="col-md-6"><div class="mb-3"><label>Email *</label><input type="email" class="form-control" name="email" value="<?php echo set_value('email', $user->email); ?>" required></div></div>
                </div>
                <div class="mb-3"><label>Full Name *</label><input type="text" class="form-control" name="full_name" value="<?php echo set_value('full_name', $user->full_name); ?>" required></div>
                <div class="row">
                    <div class="col-md-6"><div class="mb-3"><label>New Password</label><input type="password" class="form-control" name="password"><small class="text-muted">Leave blank to keep current password</small></div></div>
                    <div class="col-md-6"><div class="mb-3"><label>Confirm Password</label><input type="password" class="form-control" name="password_confirm"></div></div>
                </div>
                <div class="mb-3"><label>Role *</label><select class="form-select" name="role" required><option value="admin" <?php echo ($user->role == 'admin') ? 'selected' : ''; ?>>Admin</option><option value="author" <?php echo ($user->role == 'author') ? 'selected' : ''; ?>>Author</option><option value="viewer" <?php echo ($user->role == 'viewer') ? 'selected' : ''; ?>>Viewer</option></select></div>
                <div class="mb-3"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" <?php echo set_checkbox('is_active', '1', ($user->is_active == 1)); ?>><label class="form-check-label">Active</label></div></div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
